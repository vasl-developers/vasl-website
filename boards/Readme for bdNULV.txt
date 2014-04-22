README for bdNULV
version 1.0
1 Aug 2011
Tom Repetti  - tomrepetti@comcast.net

Board NULV is similar to bdNUL - it's a 1-pixel-wide "board" that can be used as a placeholder to make VASL accept a particular board configuration. 

Recall that VASL only understands boards placed in rows and columns. In order to get VASL to understand the following board configuration:

---------------------------------
| 2a         |                  |
|            |                  |
|            |                  |
|            | 10               |
|            |------------------|
|            |                  |
|            |                  |
|            |                  |
|            | 22               |
---------------------------------

we use bdNUL (a 901-pixel-wide by 1-pixel-tall "board") to fit "under" bd 2a in VASL's Map Creation dialog:

   2a        10
   NUL       22


Similar to this situation, bdNULV (a 1-pixel-wide by 645-pixel-tall "board") is useful for creating the following map:

---------------------------------
|                               |
|                               |
|                               |
| 14                            |
|-------------------------------|
|              |                |
|              |                |
|              |                |
| 46           | 37             |
---------------------------------

To do this, place and crop the boards as such:

    14        NULV
    46(A-Q)   37(A-Q) 

Sure, it's possible to do this without needing bdNULV if you simply rotate the entire map 180 degrees:

   37(flipped)(A-Q)   46(flipped)(A-Q)
   14(flipped)        (leave blank)

but goshdarnit, sometimes you want the right board on top :-)

At any rate. While bdNUL should perhaps be renamed bdNULH to comply with bdNULV, I'm gonna leave it as it is because bdNUL was here first and I believe in those who have the guts to ride the bleeding edge :-)

Enjoy and let me know if you have any problems or suggestions.

