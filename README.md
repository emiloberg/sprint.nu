Sprint.nu
=========

This is a very small lunch hack script that grabs the name and release date of the current sprint of a Jira agile board and displays it on a web page.


## Demo
Real life demo: [sprint.nu](http://www.sprint.nu) and [ig.sprint.nu](http://ig.sprint.nu)


## Instructions
1. Set the username, password and url to your Jira, at the top of the script.
2. Make sure `$getBoardIDsMode` is set to 'true';
3. Visit the page. You'll now see a list of boards (projects), grab the `[id]` of the board (project) you want to display
4. put the ID number in the `$jiraBoardId` variable.
5. Set `$getBoardIDsMode` to 'false'
6. All done, visit the page!

## Fine Print
Must be run on a server where cURL is allowed.

## Thanks
This is *very* inspired by the awesome site [vecka.nu](http://www.vecka.nu)


## License
[WTFPL](http://www.wtfpl.net/)
