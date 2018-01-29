TYPO3 Extension ``singleview``
#############################

.. contents:: :local:

What does it do?
****************

This extension adds few features which improves implementation of single views of other extensions.

Installation
************

Just use composer or download by Extension Manager.

::

  composer require sourcebroker/restrictfe

Usage
************

Each configuration of the singleview extension has to be registered in your ext_localconf.php file using
\SourceBroker\Singleview\Service\SingleViewService::registerConfig static method. Parameters which needs to be passed
 there are: (1) PID number of the list view page, (2) PID number of the single view page, (3)

::

    <?php
    \SourceBroker\Singleview\Service\SingleViewService::registerConfig(
        2,
        50,
        function() {
            $newsParams = \TYPO3\CMS\Core\Utility\GeneralUtility::_GET('tx_news_pi1');
 
            return !empty($newsParams['news']);
        },
        ['tx_local_breadcrumb_hide_all'],
        function() {
            $newsParams = \TYPO3\CMS\Core\Utility\GeneralUtility::_GET('tx_news_pi1');

            return 'news-'.(int)$newsParams['news'];
        }
    );

Changelog
*********

See https://github.com/sourcebroker/singleview/blob/master/CHANGELOG.rst
