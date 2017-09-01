##releasing a new version of VASL

Add new version notes to download.htm

Find first `<div class="well table">` and replicate that DIV.
* update the first link (i.e. "VASL 6.4.1") to use the new version number for the link id, href, and text
* change the "Updated" date
* update the release notes

In the previous version (now the second one):
* change the class of the download link from "btn-primary" to "btn-info"
* remove the "Get the version 6 boards" link (this always stays with the current version)

Download the new VASL vmod file and compress it, creating the new zip file, i.e. "VASLv641.zip".
Copy the zip file into the modules folder of this repo (should be the same as the href set earlier (`href="modules/VASLv641.zip"`)

Commit and Push the new module zip file and the updated download.htm to this repo.

Github Pages will get updated soon after the files are pushed, and the new changes will be visible on the website.


## vasl setup files
To rebuild the setup include file (/include/scen.html), run

```
jekyll build
```

This will regenerate the file based on the fodlers and files found in \setups, and the resulting changes to `/include/scen.html` will need to get commited and pushed.

vasl-website
============

Source code for the VASL website

Rodney's original website was used as the basis for this, with a lot of updates.

Here is where the old site was resurrected from:

http://web.archive.org/web/20090802172423/http://www.vasl.org/index.htm
