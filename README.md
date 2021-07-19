# phpBB List Manager
![GitHub release (latest by date)](https://img.shields.io/github/v/release/adrianb11/phpbb_listmanager?include_prereleases&style=flat-square)
[![Software License](https://img.shields.io/badge/licence-GPL--2.0--only-brightgreen.svg?style=flat-square)](LICENSE.md)

## Description
This is a phpBB extension that allows you to convert forums or categories into boards for use as a task/project manager.

Each sub-forum is classed as a list and topics classed as cards.
* Forum or Category = Board
* Sub-Forums = Lists
* Topics = Cards

If a forum is set as a board, it will display all sub-forums as lists, and all topics displayed under each list as cards.  Cards can now be viewed directly from the board manager.

Currently, cards can only be viewed and any replies need to be made in the actual topic directly.  Replies from within a card will be added in a future update.

BBCodes, attachments, smilies, and signatures are all displayed as though the topic was viewed directly.

## User Guide
![](https://i.ibb.co/BT1PHG2/List-Manager-CP.png)  
* **View Board**
  * All sub-forums are displayed as lists.
  * Each list contains all topics in the forums.
![](https://i.ibb.co/XksKpQZ/View-Board.png)

* **View Card**
  * Clicking on a card will display a new element with the topic contents.
  * Clicking outside of the new element will close it and return to the board.
![](https://i.ibb.co/hRhmZZX/Card-Display.png)

* **List Manager CP**
  * Manage Current Boards
    * Displays all boards which have been created.  Action column has buttons to view board which will take you directly to the forum, and a delete board button.
  * Create New Board
    * A select box is displayed with all forums/categories in a list.  Selecting an entry and submitting will add the selected forum/category as a new board.
    
* **Settings**
  * In the ACP, view the extensions configuration page `Extensions -> List Manager Module`. 
    * `Is the module enabled? - Yes / No` - Sets whether the module is enabled or not.  Setting to Yes will show any boards created and display the `List Manager CP` navbar link.
  * **Theme Specific Settings**
    * Various settings to change how the page is displayed and how the JS interacts with the page.
      * `Length of time to fade background`
      * `Array of html elements and CSS changes to apply when fading out the background`
      * `Array of html elements and CSS changes to apply when fading in the background`
      * `Should the post profile element be displayed?`
      * `List of elements to remove if the post profile is not shown`
      * `Array of html elements and CSS changes to apply when removing the post profile`
      * `List of elements to remove when viewing topics`
      * `Array of html elements and CSS changes to apply when viewing a topic`
      * `List of elements to remove when creating a new post`
      * `Array of html elements and CSS changes to apply when creating a new topic`
      * `List of elements to remove when submitting a form`
      * `List of button names which should be watched when submitting forms`
      * `JavaScript to correctly select the button or <a> element when clicking a submit button`
      * `Array of html elements and CSS changes to apply when submitting a form`
      * `List of elements to remove when loading drafts`
      * `List of button names which should be watched to post a reply`
      * `JavaScript to correctly select the button or <a> element when clicking a post reply button`
      * `List of button names which should be watched when reloading a card`
      * `JavaScript to correctly select the button or <a> element when clicking a post button`
![](https://i.ibb.co/pyCVrfd/List-Manager-Settings-01.png)
![](https://i.ibb.co/ZNt8689/List-Manager-Settings-02.png)

* **Permissions**
  * Administrators
    * `List Manager - Can use the List Manager admin feature?`:- Can this group change the extension settings?
![](https://i.ibb.co/fnxR71x/Administrator-Permissions.png) 
  * Group Permissions:-
    * `List Manager - Can manage boards?`:- Can this group access the List Manager CP?
    * `List Manager - Can add boards?`:- Can this group create new boards?
    * `List Manager - Can delete boards?`:- Can this group remove boards?
    * `List Manager - Can view boards?`:- Can this group view boards?
![](https://i.ibb.co/rv3HJJg/User-Group-Permissions.png)

## Install
1. [Download the latest release](https://github.com/adrianb11/phpbb_listmanager/releases).
2. Unzip the extension and copy the folder `adrianb11` to the `ext` directory of your phpBB forum (`ext/adrianb11/listmanager`).
3. After uploading the extension, it will appear in the Extension Manager (`ACP -> Customise -> Extension Management -> Manage extensions`).
4. Find the extension `List Manager` under the Disabled Extensions list, and click `Enable` under the `Actions` column.
5. Extension can now be enabled through `Extensions -> List Manager Module`.
6. Permissions for each usergroup/user can now be set.

## Update
1. Disable the extension by clicking the `Disable` link in `ACP -> Customise -> Extension Management -> Manage extensions` found next to the `List Manager` extension.
2. Delete the directory `/ext/adrianb11/listmanager` (this will not affect any boards you have setup).
3. Follow steps 1-4 from the install guide.

## UnInstall
1. Disable the extension by clicking the `Disable` link in `ACP -> Customise -> Extension Management -> Manage extensions` found next to the `List Manager` extension.
2. To permanently uninstall, click `Delete Data` and then delete the `/ext/adrianb11/listmanager` directory.  Any changes the extension has made will now be reversed.

## Requirements
* phpBB3.2 && PHP 5.4.7+
* or
* phpBB3.3 && PHP 7.1.3+

## Support
If you find any issues or have a feature request, [please create a new issue](https://github.com/adrianb11/phpbb_listmanager/issues).

## License
GNU General Public License v2.0. Please see [License File](LICENSE.md) for more information.
