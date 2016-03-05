require 'jekyll/document'

module Jekyll

  # Recover from strange exception when starting server without --auto
  class SitemapFile < StaticFile
    def write(dest)
      true
    end
  end

  class SitemapGenerator < Generator
    priority :lowest

    # Config defaults
    FILE_NAME = "/setups/scen.html"

    # Goes through setup files and generates listing
    def generate(site)
      # Configuration
      sitemap_config = site.config['sitemap'] || {}

      # create destination directory if it doesn't exist yet
      Dir::mkdir(site.dest) if !File.directory? site.dest
      $fileHtml = File.new(File.join(site.dest, FILE_NAME), "w+")

      $base = site.dest

      traverse(File.join(site.dest, "/setups"))

      $fileHtml.close()

      # Keep the file from being cleaned by Jekyll
      site.static_files << Jekyll::SitemapFile.new(site, site.dest, "/", FILE_NAME)

      FileUtils.cd('./include')
      FileUtils.cp File.join(site.dest, FILE_NAME), File.join(FileUtils.pwd(), "scen.html")
    end

    def process(path)
      if File.directory?(path)
        dir = File.basename(path)
        level = path.count('/') - 4
        h = "h" + level.to_s
        $fileHtml.puts "<"+h+">" + dir + "</"+h+">" if dir != "Enhanced"
      else
        downloadPath = path.sub($base, ".")
        $fileHtml.puts "<p><a href='"+downloadPath+"'>" + File.basename(path, ".vsav") + "</a></p>"
      end
    end

    def traverse(path='.')
      Dir.entries(path).each do |name|
        next  if name == '.' or name == '..'

        path2 = path + '/' + name
        process(path2) if File.basename(path2) != "scen.html"

        traverse(path2)  if File.ftype(path2) == "directory"
      end
    end
  end
end