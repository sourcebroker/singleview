Changelog
---------

master
~~~~~~
1) [TASK] Drop style CI.

2.1.1
~~~~~
1) [TASK] Add support for canonical URLs for TYPO3 core EXT:code

2.1.0
~~~~~
1) [TASK] Add support for TYPO3 10.4.

2.0.0
~~~~~
1) [TASK] Drop support for TYPO3 7.6, TYPO3 8.7. Add support for TYPO3 9.5. For TYPO3 7.6 ad 8.7 install version 1.3.
2) [BUGFIX] Database compatibility.

1.3.1
~~~~~
1) [BUGFIX] Lack of dependency to TYPO3 7.6.0 in composer.json.

1.3.0
~~~~~
1) [FEATURE] Implement support for TYPO3 7.6 and PHP 5.6.
2) [!!!][FEATURE] Disable hashBase customization by default for TYPO3 higher or equal 8.5.
3) [BREAKING] Remove useless feature to throw page not found exception on missing cHash.
4) [FEATURE] Change $boot to call_user_func().
5) [!!!][FEATURE] Enable hashBase customization by default for all TYPO3 versions.
6) [BUGFIX] Cast $id to int (it was php7 type cast before).
7) [DOC] Docs changes.

1.2.2
~~~~~
1) Add missing licence in composer.json.
2) Update ext_emconf.php ext version.

1.2.1
~~~~~
1) Fix error in docs.
2) Update Docs.
3) Add styleci.io PSR-2 code changes.
4) Update phpdocs.
5) Change ext description.
6) Update ext_emconf.php ext version.

1.2.0
~~~~~
1) Add styleci.io code checks / reformat code according to PSR-2.
2) Add ext icon.
3) Add ext licence.
4) Add ext badges.
5) Update ext_emconf.php ext version.

1.1.0
~~~~~
1) Add description, authors, replace to composer.json. Add vendors to /.Build for future tests and auto complete.

1.0.0
~~~~~
1) Init version.
