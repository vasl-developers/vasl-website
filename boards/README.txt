README for BFP Overlays
16Aug09 - Tom Repetti

Boards BFPE and BFPF go in your boards folder. The overlay files (ovrBFPH, ovrBFPV, and ovrBFPO) go in your boards/overlays folder.

Where to place the overlays:

Name      VASL Name    hex1-hex2
--------------------------------
BFP-06a    bfpo6 	i2-none
BFPH1      bfphi        k1-none
BFPH2      bfphii       (as per SSR)
BFPV1      bfpvi        k1-none
BFPV2      bfpvii       (as per SSR)
BFPV3      bfpviii      k1-none

For BFP-06a, the VASL Name to enter into the "Add Overlay" dialog box is beta-foxtrot-papa-OSCAR-6 (bfpo6, all lower case) NOT the number ZERO-SIX!!!  And yes, you only specify one hex for this overlay now - unlike a previous version where you had to specify i2-j2.

