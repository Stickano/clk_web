<div id="content">
            <h1>Argument usage and examples <a name='Argument usage and examples'></a></h1>

            <p>
Created Monday 24 December 2018
</p>

<p>
Very few restrictions is are made when administrating your boards, and you are able to recursivly add new items to boards, lists and comments. 
</p>

<table>
<thead><tr>
  <th align="left">Tip</th>
</tr></thead>
<tr>
  <td align="left">You can choose to either use full argument description for board, list and card, or use their shortcut code:</td>
</tr>
<tr>
  <td align="left">Board: --board  or  -b</td>
</tr>
<tr>
  <td align="left">List: --list  or  -l</td>
</tr>
<tr>
  <td align="left">Card: --card  or -c</td>
</tr>
</table>

<br>
<br>

<h2>General usage</h2>

<p>
These following steps will give you a general idea, how to navigate your kanban boards and their content. It will show basic instructions for Create, Read, Update and Delete (CRUD) methods.
</p>

<h5>READ content</h5>

<p>
You read content from each item by pointing on which element to read. There a 3 element levels to point to and read from: Boards, Lists and Cards. 
</p>

<p>
<b># Show all boards:</b><br>
$ clk -b
</p>

<p>
<b># Select specific board, and show all lists:</b><br>
$ clk -b 2
</p>

<p>
<b># Select a list and see its cards:</b><br>
$ clk -b 2 -l 4
</p>

<p>
<b># Select a card and see its content:</b><br>
$ clk -b 2 -l 4 -c 1
</p>

<br>

<h5>CREATE content</h5>

<p>
To create new content use the <i>--new-[element]</i>  keyword.
</p>

<table>
<thead><tr>
  <th align="left">Tip</th>
</tr></thead>
<tr>
  <td align="left">If your item titles (values) has spaces in them, encapsulate the title in double quotes ("), otherwise the double quotes is not necessary.</td>
</tr>
</table>

<br>

<p>
<b># Create a new board:</b><br>
$ clk --new-board "Board Name"
</p>

<p>
<b># Create a new list in board 2:</b><br>
$ clk -b 2 --new-list Backlog
</p>

<p>
<b># Create a new card in list 4, in board 2:</b><br>
$ clk -b 2 -l 4 --new-card "User Story"
</p>

<p>
<b># Create a new checklist in card 1, in list 4 etc:</b><br>
$ clk -b 2 -l 4 -c 1 --new-check Checklist
</p>

<p>
<b># Create a new checkist point in checklist 2, card 1 .. :</b><br>
$ clk -b 2 -l 4 -c 1 -p 2 --new-point "Do this"
</p>

<p>
<b># Set the description for a card:</b><br>
$ clk -b 2 -l 4 -c 1 --description "A very informative description about this card."
</p>

<p>
<b># Add a comment to a card:</b><br>
$ clk -b 2 -l 4 -c 1 --comment "When doing this, also remember that.."
</p>

<br>

<h5>DELETE content</h5>

<p>
To delete already existing content, use the <i>--del-[element]</i>  keyword.
</p>

<p>
<b># Delete a board:</b><br>
$ clk --del-board 2
</p>

<p>
<b># Delete a list:</b><br>
$ clk -b 2 --del-list 4
</p>

<p>
<b># Delete a card:</b><br>
$ clk -b 2 -l 4 --del-card 3
</p>

<p>
<b># Delete a checklist:</b><br>
$ clk -b 2 -l 4 -c 3 --del-check 5
</p>

<p>
<b># Delete a checklist point:</b><br>
$ clk -b 2 -l 4 -c 3 -p 1 --del-point 3
</p>

<p>
<b># Delete a comment: </b><br>
$ clk -b 2 -l 4 -c 3 --del-comment 2
</p>

<br>

<h5>UPDATE content</h5>

<p>
To update content, either board, list or card, point to the element you want to update and trail it with a <i>--edit</i>  keyword followed by its new value.
</p>

<p>
<b># To update the name of a board:</b><br>
$ clk -b 2 --edit "A new board name"
</p>

<p>
<b># To update the name of a list:</b><br>
$ clk -b 2 -l 4 --edit "A new list name"
</p>

<p>
<b># To update the name of a card:</b><br>
$ clk -b 2 -l 4 -c 3 --edit "A new card name"
</p>

<p>
<b># To update the name of a checklist:</b><br>
$ clk -b 2 -l 4 -c 3 -p 5 --edit "A new checklist name"
</p>

<br>

<h5>UPDATE extra</h5>

<p>
This sort of fall into the update category, yet I felt it was a bit outsite the new naming steps from above.
</p>

<p>
<b># To check a point in a checklist (mark/un-mark):</b><br>
$ clk -b 2 -l 4 -c 1 -p 5 --point 3
</p>

<p>
<b># To set a color label on a card (red, green, yellow, blue and cyan):</b><br>
$ clk -b 2 -l 4 -c 3 --label red
</p>

<br>

<h2>Recursive actions</h2>

<p>
You can perform many recursive actions on your boards, lists and cards - All you need to know is, that the last element you have selected, is the element that will be worked on. 
</p>

<p>
All values are space seperated, so encapsulate content with spaces in double quotes (").
</p>

<h5>Boards</h5>

<p>
<b># To add several new boards:</b><br>
$ clk --new-board "Board 1" "Board 2" "Board 3"
</p>

<p>
<b># To delete several boards:</b><br>
$ clk --del-board 2 4 6
</p>

<br>

<h5>Lists</h5>

<p>
<b># To add several new lists:</b><br>
$ clk -b 2 --new-list "List 1" "List 2" "List 3"
</p>

<p>
<b># To delete several lists:</b><br>
$ clk -b 2 --del-list 1 3 5
</p>

<br>

<h5>Cards</h5>

<p>
<b># To add several new cards:</b><br>
$ clk -b 2 -l 4 --new-card "Card 1" "Card 2" "Card 3"
</p>

<p>
<b># To delete several cards:</b><br>
$ clk -b 2 -l 4 --del-card 3 6 9
</p>

<br>

<h5>Extra</h5>

<p>
There's a lot more workflow examples for recursive actions. Again, all that matters is the last selected element and which actions to perform on that element. When you create a new element, that element will be selected as the latest to perform actions on.
</p>

<p>
<b># We could i.e. set the description for several cards at once:</b><br>
$ clk -b 2 -l 4 -c 2 --description "A description for card 2" -c 4 --description "A description for card 4"
</p>

<p>
<b># Same goes for comments:</b><br>
$ clk -b 2 -l 4 -c 2 --comment "A comment in card 2" -c 4 --comment "A comment in card 4"
</p>

<p>
<b># And the same goes for checklists, checklists points, marking/un-marking points and so forth. </b>
</p>

<p>
<b># We can also check several points at once:</b><br>
$ clk -b 2 -l 4 -c 3 -p 5 --point 1 2 3 5
</p>

<p>
<b># You can even take it a step deeper, though. Ex. to create a board, with several lists, with several cards, and with card descriptions:</b><br>
$ clk --new-board "Board 1" --new-list "List 1" --new-card "Card 1 in List 1" --description "Description for card 1 in List 1" --new-card "Card 2 in List 1" --new-list "List 2" --new-card "Card 1 in List 2" --description "Description for card 1 in List 2"
</p>

<br>

<h2>Cloud actions</h2>

<p>
If you create an online profile for this application, you will have additional options to save and receive boards from the cloud, along with collaboration on projects, in teams. You can choose to either create the profile on this website, or you can do it directly in the application. Once you're a registered profile, additional board overview will also be available from this website, after you've logged in.
</p>

<h5>Profile</h5>

<p>
Once you've created a profile, you can choose to either login each time you want to communicate with the cloud, or you can store your login information to disc, allowing you to auto-login on cloud requests. You password will be stored in a hashed state and no clear-text passwords will be up for the grapping.
</p>

<p>
<b># Create a new profile:</b><br>
$ clk --new-profile <a href="mailto:valid@emailaddress.com" title="valid@emailaddress.com" class="mailto">valid@emailaddress.com</a> --password strongpassword123
</p>

<p>
<b># To login:</b><br>
$ clk --login <a href="mailto:valid@emailaddress.com" title="valid@emailaddress.com" class="mailto">valid@emailaddress.com</a> --password strongpassword123
</p>

<p>
<b># To store the user information to disc:</b><br>
$ clk --login <a href="mailto:valid@emailaddress.com" title="valid@emailaddress.com" class="mailto">valid@emailaddress.com</a> --password strongpassword123 --save-user
</p>

<p>
<b># If you do not save the user information to disc, make sure to do the login step before making cloud requests.</b><br>
<b># The following examples will assume that the user information has been stored on disc (no login needed).</b>
</p>

<br>

<h5>Boards</h5>

<p>
<b># To save a board to the cloud:</b><br>
$ clk --cloud-save 5
</p>

<p>
<b># To receive a list all boards available in he cloud:</b><br>
$ clk --cloud-boards
</p>

<p>
<b># To receive a specific board and all its content: </b><br>
$ clk --cloud-get 2
</p>

<br>

<h5>Members</h5>

<p>
You can only add members and give administrator rights, if you're an administrator yourself, or the board owner. You can only add members to boards, which has been saved to the cloud. 
</p>

<p>
<b># To see all members of a board:</b><br>
$ clk -b 2 --members
</p>

<p>
<b># To grant administrator rights to a board member:</b><br>
$ clk -b 2 --admin 5
</p>

<p>
<b># To invite a user to a board: </b><br>
$ clk -b 2 --new-member <a href="mailto:valid@emailaddress.com" title="valid@emailaddress.com" class="mailto">valid@emailaddress.com</a>
</p>

<p>
<b># To remove a user from a board:</b><br>
$ clk -b 2 --del-member <a href="mailto:valid@emailaddress.com" title="valid@emailaddress.com" class="mailto">valid@emailaddress.com</a> 
</p>

<table>
<thead><tr>
  <th align="left">Tip</th>
</tr></thead>
<tr>
  <td align="left">You can add and delete members recursively as well. Just seperate the email-address' with space.</td>
</tr>
</table>

<br>
<br>

<h2>Settings</h2>

<p>
CLI Kanban comes with a few optional, user defined settings. It is based on On/Off, or True/False, so you just point to the setting item to activate/deactivate.
</p>

<p>
<b># Get an overview of user settings and preferences:</b><br>
$ clk --settings
</p>

<p>
<b># To click (activate/deactivate) a certain setting:</b><br>
$ clk --settings 5
</p>

<br>



            <br>
            <span class="backlinks">
                <hr class='footnotes'>
                <b>Backlinks:</b>
                <a href='./index.html'>Home</a>
                <br /><br />
            </span>

            
        </div>