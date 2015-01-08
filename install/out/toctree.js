
      var tree;
      
      function treeInit() {
      tree = new YAHOO.widget.TreeView("treeDiv1");
      var root = tree.getRoot();
    
	
		var objd4e9 = { label: "Installing VASL", href:"src/t_installing_vasl.html", target:"contentwin" };
    var d4e9 = new YAHOO.widget.TextNode(objd4e9, root, false);var objd4e19 = { label: "Checking the Java Runtime Engine (JRE)", href:"src/t_checking_jre.html", target:"contentwin" };
    var d4e19 = new YAHOO.widget.TextNode(objd4e19, d4e9, false);var objd4e29 = { label: "Installing the VASSAL engine", href:"src/t_installing_vassal.html", target:"contentwin" };
    var d4e29 = new YAHOO.widget.TextNode(objd4e29, d4e9, false);var objd4e39 = { label: "Installing the VASL module", href:"src/t_installing_vasl_module.html", target:"contentwin" };
    var d4e39 = new YAHOO.widget.TextNode(objd4e39, d4e9, false);var objd4e49 = { label: "Installing VASL map files and overlay files", href:"src/t_installing_vasl_map_files.html", target:"contentwin" };
    var d4e49 = new YAHOO.widget.TextNode(objd4e49, d4e9, false);var objd4e59 = { label: "Installing extensions", href:"src/t_installing_vasl_extensions.html", target:"contentwin" };
    var d4e59 = new YAHOO.widget.TextNode(objd4e59, d4e9, false);

      tree.draw(); 
      } 
      
      YAHOO.util.Event.addListener(window, "load", treeInit); 
    