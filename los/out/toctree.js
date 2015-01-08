
      var tree;
      
      function treeInit() {
      tree = new YAHOO.widget.TreeView("treeDiv1");
      var root = tree.getRoot();
    
	
		var objd4e9 = { label: "About LOS Checking", href:"src/c_about_los_checking.html", target:"contentwin" };
    var d4e9 = new YAHOO.widget.TextNode(objd4e9, root, false);var objd4e19 = { label: " Checking Line of sight (LOS) ", href:"src/t_checking_los.html", target:"contentwin" };
    var d4e19 = new YAHOO.widget.TextNode(objd4e19, d4e9, false);var objd4e26 = { label: "LOS checking configuration", href:"src/c_los_checking_configuration.html", target:"contentwin" };
    var d4e26 = new YAHOO.widget.TextNode(objd4e26, d4e9, false);

      tree.draw(); 
      } 
      
      YAHOO.util.Event.addListener(window, "load", treeInit); 
    