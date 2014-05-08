# Rake task to copy local files to remote server via FTP
# required credentials.yml file, that contains keys:
# server, username, password

require "net/ftp"
require "yaml"
require "rubygems"
require "zip"

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
    # ftp.debug_mode = true
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
          if file_extension != ".psd"
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

class Deployer
  def self.run(local, remote)
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
      ftp_client.copy(entry, local + "/boards/" + entry)
    end

  ensure
    ftp_client.ftp.close
  end
end

# copy all entries in local public directory to remote www directory
desc "deploy via ftp"
task :deploy do
  #Boards.zip(Dir.pwd)
  Deployer.run(".", "public_html/vasl.info")
end

desc "zip board files and deploy via ftp"
task :boards do
  Boards.zip(Dir.pwd)
end