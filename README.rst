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
\SourceBroker\Singleview\Service\SingleViewService::registerConfig static method as below.

::

    <?php
    \SourceBroker\Singleview\Service\SingleViewService::registerConfig(
        // PID of the list view page
        2, 
        // PID of the single view page
        50,
        // Closure which returns boolean or boolean value as a condition which needs to be met to apply content_from_pid replacement
        function() {
            $newsParams = \TYPO3\CMS\Core\Utility\GeneralUtility::_GET('tx_news_pi1');
 
            return !empty($newsParams['news']);
        },
        // (optional) Array of strings with names of the fields which will be copied from single page to list page
        ['tx_local_breadcrumb_hide_all'],
        // (optional) Closure which returns string or string which will be used to create hashBase
        function() {
            $newsParams = \TYPO3\CMS\Core\Utility\GeneralUtility::_GET('tx_news_pi1');

            return 'news-'.(int)$newsParams['news'];
        }
    );

Changelog
*********

See https://github.com/sourcebroker/singleview/blob/master/CHANGELOG.rst
