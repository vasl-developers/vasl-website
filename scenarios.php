<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
<link rel="icon" href="./favicon.ico" type="image/x-icon">
<title>VASL - Download Scenarios</title>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
<link href="./css/vasl_styles.css" rel="stylesheet">
<script type="text/javascript">
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-50258794-1', 'auto');
ga('send', 'pageview');
</script>
</head>
<body>
<div id="navbar"></div>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-2 sidebar"></div>
    <div class="main-content col-md-10">

      <div class="userHeader">
        <h1 class="pull-right">VASL Scenario Setups</h1>
      </div>

      <div class="panel panel-default">
        <div class="panel-body">
          <h4>Status Update</h4>
          <p>Patrick Ireland is currently working on updating all SK scenarios to VASL v6.2.2. It is planned, that these will eventually become available via vasl.info on this page.</p>
          <p>There are several collections. Most of them are very outdated, one of which included every scenario of the core modules among them - for VASL v4.</p>
          <p>Then there is another collection which includes roughly 150 VASL setups stretching from versions v5.9.2 to v6.2.2. There are plans to update those as well (and as these versions are not that old, there is a solid base to start from). I have no idea about the time-table on that project. This latter collection is mixed MMP and TPP, while the SK collection is systematic, running through all the SK scenario numbers. Because updating setups is a business without end due to the release of new VASL versions, some consideration it put on thoughts on documentation/designation as to make updates more easy in the future (i.e. that one will know exactly from where to start if one plans on updating an existing setup).</p>
          <p>It is likely, that the SK collection will be finished and available first and afterwards the other collection is worked on which will become available in batches.</p>
          <p>As a preview, head to <a href="https://github.com/atuline/ASLSK-Scenarios#asl-starter-kit-scenario-setups" target="_blank">https://github.com/atuline/ASLSK-Scenarios</a> and you can try out the SK setups.</p>
          <p>Once things are up and running, it might become be possible for anyone to submit setups as long as they meet certain standards and naming conventions.</p>
        </div>
      </div>

      <div id="setups" class="table-responsive">
        <? include 'scan.php'; ?>
      </div>

    </div>
  </div>
</div>

<footer></footer>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  $("#navbar").load("./include/navbar.htm", function() {
    $("ul.navbar-nav li.download").addClass("active");
  });
  $("div.sidebar").load("./include/sidebar.htm", function() {
    $("a.setups").addClass("active");
  });
  $("footer").load("./include/copyright.htm");
});
</script>
</body>
</html>
