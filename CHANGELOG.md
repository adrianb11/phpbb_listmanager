# Changelog

## [v0.1.3](https://github.com/adrianb11/phpbb_listmanager/tree/v0.1.3) (2021-07-19)

###Added
- Added a check if user is allowed to create new card (topic) in forums.
- "Create New Card ..." button is displayed if user has permissions to create new card (topic).
- Display notification if a board (forum, cat) does not contain any cards (topics).
- Setting to limit how many cards (topics) are displayed for each board (forum, cat).
- Settings to change JavaScript behavior.
- Additional language entries.

###Updated
- Cards (topics) are now displayed by calling viewtopic.php.
- Board view now uses an extract from viewforum.php and functions_display.php to get list of boards (forums, cat) and cards (topics) to display.
- Multiple changes in styles/all/theme/postloader.js.
- Update version number to v0.1.3.

###Fixed
- Fixed log entries not using language file.

###Removed
- Deleted controller/post_controller.php (redundant).
- Deleted controller/card_controller.php (redundant).
- Deleted styles/all/template/listmanager_topic_display.html (redundant).

[Full Changelog](https://github.com/adrianb11/phpbb_listmanager/compare/v0.1.2...v0.1.3)

## [v0.1.2](https://github.com/adrianb11/phpbb_listmanager/tree/v0.1.2) (2021-05-25)

###Fixed
- Corrected issue with composer.json

###Updated
- Update version number to v0.1.2

[Full Changelog](https://github.com/adrianb11/phpbb_listmanager/compare/v0.1.1...v0.1.2)

## [v0.1.1](https://github.com/adrianb11/phpbb_listmanager/tree/v0.1.1) (2021-05-25)
###Added
- CHANGELOG.md

###Fixed
- Corrected issue with composer.json
- Added app.php to listmanager/get/topic URL in postloader.js

###Updated
- Update version number to v0.1.1

[Full Changelog](https://github.com/adrianb11/phpbb_listmanager/compare/v0.1.0...v0.1.1)


## [v0.1.0](https://github.com/adrianb11/phpbb_listmanager/tree/v0.1.0) (2021-05-24)

**Initial Release**
