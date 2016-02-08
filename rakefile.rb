# Rake task to copy local files to remote server via FTP
# required credentials.yml file, that contains keys:
# server, username, password

require "net/ftp"
require "yaml"
require "rubygems"
require "zip"
require "jsonify"

class FTPClient
  attr_reader :remote_path

  def initialize(remote_path)
    @remote_path = remote_path
  end

  def ftp
    @ftp ||= Net::FTP.new
  end

  def connect
    ftp.connect(credentials["server"])
    ftp.login(credentials["username"], credentials["password"])
    ftp.passive = true
    #ftp.debug_mode = true
    ftp.chdir(remote_path)
  end

  def copy_recursive(file_or_dir, prefix_to_remove = nil)
    remote_file_or_dir = prefix_to_remove ? file_or_dir.gsub(prefix_to_remove, "") : file_or_dir
    if File.directory?(file_or_dir)
      puts "copying directory #{remote_file_or_dir}"
      #ftp.mkdir(remote_file_or_dir)
      #Dir.glob(file_or_dir + "/*").each { |entry| copy_recursive(entry, prefix_to_remove) }
    else
      puts "copying file #{remote_file_or_dir}"
      ftp.putbinaryfile(file_or_dir, remote_file_or_dir)
    end
  end

  def copy(file, target)
    puts "copying file #{file}"
    ftp.putbinaryfile(file, target)
  end

  def credentials
    @credentials ||= YAML.load_file("credentials.yaml")
  end
end

class Boards
  def self.zip(cwd)
    FileUtils.mkdir_p cwd + "/zip/"
    Zip.continue_on_exists_proc = true
    Zip.default_compression = Zlib::BEST_COMPRESSION
    Dir.chdir("/vasl/boards/src/")
    Dir.glob("*").each do |folder|
      zipfile_name = folder + ".z"
      puts zipfile_name
      Zip::File.open(zipfile_name, Zip::File::CREATE) do |zipfile|
        Dir[File.join(folder, '**', '**')].each do |file|
          file_extension = File.extname(file)
          if file_extension != ".psd" && file_extension != ".xcf"
            puts ".. " + file.sub(folder+'/', '')
            zipfile.add(file.sub(folder+'/', ''), file)
          end
        end
      end
      filename = folder + ".zip"
      Zip::File.open(filename, Zip::File::CREATE) do |zipfile|
        zipfile.add(zipfile_name.sub('.z', ''), zipfile_name)
      end
      FileUtils.rm zipfile_name
      FileUtils.mv filename, cwd + "/zip/"
    end
    Dir.chdir(cwd)
  end
end

class Packages
  def self.zip(cwd, boardList, targetFileName)
    FileUtils.mkdir_p cwd + "/zip/"
    Zip.continue_on_exists_proc = true
    Zip.default_compression = Zlib::BEST_COMPRESSION
    Dir.chdir("/vasl/boards/src/")
    Zip::File.open(targetFileName, Zip::File::CREATE) do |targetZipfile|
      Dir[boardList].each do |folder|
        zipfile_name = folder + ".z"
        puts zipfile_name
        Zip::File.open(zipfile_name, Zip::File::CREATE) do |zipfile|
          Dir[File.join(folder, '**', '**')].each do |file|
            file_extension = File.extname(file)
            if file_extension != ".psd" && file_extension != ".xcf"
              puts ".. " + file.sub(folder+'/', '')
              zipfile.add(file.sub(folder+'/', ''), file)
            end
          end
        end
        targetZipfile.add(zipfile_name.sub('.z', ''), zipfile_name)
      end
    end
    FileUtils.rm Dir.glob('*.z')
    FileUtils.mv targetFileName, cwd + "/zip/"
    Dir.chdir(cwd)
  end
end

class Deployer
  def self.run(local, remote)
    cwd = Dir.pwd
    ftp_client = FTPClient.new(remote)
    ftp_client.connect

    Dir.glob(local + "/*.htm").each do |entry|
      ftp_client.copy_recursive(entry, local + "/")
    end
    ftp_client.copy_recursive("./css", local + "/")
    ftp_client.copy_recursive("./fonts", local + "/")
    ftp_client.copy_recursive("./images", local + "/")
    ftp_client.copy_recursive("./include", local + "/")
    ftp_client.copy_recursive("./js", local + "/")
    ftp_client.copy_recursive("./users_guide", local + "/")

    Dir.chdir("zip")
    Dir.glob("*.zip").each do |entry|
      if entry[0,5] == "bdBFP" || entry[0,3] == "BFP"
        ftp_client.copy(entry, local + "/boards/bfp/" + entry)
      elsif entry[0,5] == "bdPBR"
        ftp_client.copy(entry, local + "/boards/mmp/" + entry)
      elsif entry[0,6] == "bdRBv2"
        ftp_client.copy(entry, local + "/boards/mmp/" + entry)
      elsif entry[0,5] == "bdFrF"
        ftp_client.copy(entry, local + "/boards/frf/" + entry)
      else
        ftp_client.copy(entry, local + "/boards/" + entry)
      end
    end

    Dir.chdir(cwd)
    version_file_name = "/vasl/boards/v5boardVersions.txt"

    json = Jsonify::Builder.new(:format => :pretty)

    text=File.open(version_file_name).read
    text.gsub!(/\r\n?/, "")
    text.each_line do |line|
      line.gsub!(/\n?/, "")
      s = line.split(' = ');
      #puts "#{s[0]}: #{s[1]}"
      board = s[0]
      version = s[1]
      json.tag!(board, version)
    end

    puts json.compile!

    versions = File.new(cwd + "/boards/versions.json", "w+")
    versions.write(json.compile!)
    versions.close

    ftp_client.copy(versions, "boards/versions.json")

  ensure
    ftp_client.ftp.close
  end
end

desc "deploy via ftp"
task :deploy do
  Deployer.run(".", "public_html/vasl.info")
end

desc "zip board files"
task :boards do
  Boards.zip(Dir.pwd)
end

desc "package board files together in groups"
task :package do
  Packages.zip(Dir.pwd, "bd[1-9][a,b]", "bds1a-9b.zip")
  Packages.zip(Dir.pwd, "bd[p-z]", "v6bdsp-z.zip")
  Packages.zip(Dir.pwd, "bd[a-h]", "DASLbdsa-h.zip")
  Packages.zip(Dir.pwd, "bd0[0-9]", "v6bds00-09.zip")
  Packages.zip(Dir.pwd, "bd1[0-9]*", "v6bds10-19.zip")
  Packages.zip(Dir.pwd, "bd2[0-9]", "v6bds20-29.zip")
  Packages.zip(Dir.pwd, "bd3[0-9]", "v6bds30-39.zip")
  Packages.zip(Dir.pwd, "bd4[0-9]", "v6bds40-49.zip")
  Packages.zip(Dir.pwd, "bd5[0-9]", "v6bds50-59.zip")
  Packages.zip(Dir.pwd, "bd6[0-9]", "v6bds60-69.zip")
  Packages.zip(Dir.pwd, "bd7[0-9]", "v6bds70-79.zip")
  Packages.zip(Dir.pwd, "bd[0-9][0-9]*", "v6boardsAll.zip")

  Packages.zip(Dir.pwd, "bdBFP[A-Z]", "BFP_SingleWide.zip")
  Packages.zip(Dir.pwd, "bdBFPDW[0-9][a,b]", "BFP_DoubleWide.zip")
end

task :rename do
  Dir.chdir("/tmp/ov/")
  Dir.glob("*").each do |entry|
    FileUtils.mv entry, entry + ".zip"
  end
end