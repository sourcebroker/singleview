TYPO3 Extension ``singleview``
#############################

  .. image:: https://styleci.io/repos/115010338/shield?branch=master
    :target: https://styleci.io/repos/115010338

  .. image:: https://poser.pugx.org/sourcebroker/singleview/v/stable
    :target: https://packagist.org/packages/sourcebroker/singleview

  .. image:: https://poser.pugx.org/sourcebroker/singleview/license
    :target: https://packagist.org/packages/sourcebroker/singleview

.. contents:: :local:

What does it do?
****************

Main purpose of this extension is to allow to display single view on different template while **keeping URLs user and SEO friendly**.
For sure you can easily imagine pages where boxes in sidebar are different on the single page than on the list page. Normally in such cases it is needed to insert single plugin on different page (usually subpage of list view) which finally makes URLs ugly because of additional segment (e.g. */news/news/lorem-ipsum-dolor*).
By using **singleview** extension you can easily omit the useless path segment in your URL (*/news* in example above), but still keep single plugin on different page with different page template.

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
