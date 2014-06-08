SpaceCaptain
============

Space Captain is a persistent browser based turned based role playing game.

It was written to support a dissertaton which foccussed on the suitability of PHP as games development language.

A large focus of the dissertation focussed of creating a product that was a cross platform and playable on as many systems as possible.
The game is completely responsive offering a optimised experience between screen sizes (especially mobile). 
Javascript was sparingly used to increase platform compatibility. Suitable fallbacks were employed where Javascript was neccesary.

Persistence was achieved through the use of a database and cron jobs.


To do
============

1) The game currently uses the old mysql driver. This is slow and insecure. PDO would be a much more suitable driver.
2) Creating a experience that didn't rely on Javascript was great but impractical. Rewriting many of the components that used hard form submissions and refreshes could greatly improve performance/usability and overall experience.
3) A new folder structure
4) Functions and classes to create DRY code.
5) Maybe MVC
6) HTML5
