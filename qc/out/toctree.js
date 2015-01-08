
      var tree;
      
      function treeInit() {
      tree = new YAHOO.widget.TreeView("treeDiv1");
      var root = tree.getRoot();
    
	
		var objd4e9 = { label: "Adding markers to the board", href:"src/c_adding_markers_to_board.html", target:"contentwin" };
    var d4e9 = new YAHOO.widget.TextNode(objd4e9, root, false);var objd4e19 = { label: " Creating a new QC bar ", href:"src/t_creating_new_marker_bar.html", target:"contentwin" };
    var d4e19 = new YAHOO.widget.TextNode(objd4e19, d4e9, false);var objd4e29 = { label: " Modifying a QC bar ", href:"src/t_modifying_custom_marker_bar.html", target:"contentwin" };
    var d4e29 = new YAHOO.widget.TextNode(objd4e29, d4e9, false);var objd4e39 = { label: " Activating a QC bar ", href:"src/t_activating_marker_bar.html", target:"contentwin" };
    var d4e39 = new YAHOO.widget.TextNode(objd4e39, d4e9, false);var objd4e49 = { label: " Deleting a QC bar ", href:"src/t_deleting_custom_marker_bar.html", target:"contentwin" };
    var d4e49 = new YAHOO.widget.TextNode(objd4e49, d4e9, false);

      tree.draw(); 
      } 
      
      YAHOO.util.Event.addListener(window, "load", treeInit); 
    