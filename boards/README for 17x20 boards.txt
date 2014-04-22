README for using 17x20 boards (1a, 1b, etc) in VASL
Tom Repetti
14Jan10

These are the VASL versions of the 17x20 boards (1a, 1b, 2a, 2b, etc). The difference between the a and b versions is in the woods half-hexes: the a side has woods in L0, N0, L20, and N20, while the b side has woods in T0, V0, T20, and V20. The scenario card should guide you as to which version you need - when in doubt, check to ensure that the woods half-hexes line up properly with the adjacent boards.

In order to get VASL to properly handle these unique board sizes, we have included another "board" called bdNUL that should be dropped into your VASL/boards folder like any other board. This board is simply a 1-pixel wide gif that sits on top of or below the 17x20 board (along hexrow 1 or 20, respectively) and gives the boards the right spacing when the 17x20 board is placed horizontally next to two 10x33 geo boards (as in the Noville scenario). Using Noville as an example, you tell VASL to place the board as such:

   43 (crop to Q-GG)    1a (flipped)

   33 (crop to Q-GG)    NUL

and off you go.

For a scenario where the 17x20 board sits on top of or below a standard geo board [EX: Nagewaza], no special shenanigans are needed - simply place the boards as usual, in a row or column. The 17x20 board version (a or b) to be used depends on the geo board it's next to - you want the woods half-hexes to line up. 

LOS is enabled on these boards, but the VASL LOS tool will report the hexes incorrectly *on the map in verbose mode* for the b-side boards, instead reporting what the hexes would be for the a-side board. No way around it, I'm afraid. The hexes reported to the VASL controls area will be correct, however, for both a- and b-side boards. [EX: in verbose mode, LOS drawn from 1aB10 to 1aJ13 will be reported to the VASL controls area as "YourName Checked LOS from B10 to J13, Range=8" and will be shown on the map itself as "B10 (Level 0) ----- J13 (Level 0) Range:8". However, LOS drawn between the same two hexes on board 1b (where B10 now becomes R10 and J13 now becomes Z13) will be correctly reported to the VASL controls area as "YourName Checked LOS from R10 to Z13, Range=8" but will still be shown on the map itself as "B10 (Level 0) ----- J13 (Level 0) Range:8".]

Email me (tomrepetti at comcast dot net) if you have any problems, and happy gaming!

- Tom