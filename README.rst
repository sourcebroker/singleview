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

This extension allows to display single view on different page than list view and still keep urls user and SEO friendly.

Look at example below for better understanding.

Lets take following list view url:

::

  https://www.example.com/list/

TYPO3 / realurl default is that when you put single view on different page then there is no easy way to remove it from
realurl links. You will get something like below. Single view on separate page named "detail":

::

  https://www.example.com/list/detail/title-of-single-item/

If you use ``ext:singleview`` then single view can be on different page than list view but the realurl links will still
look nice like below - so no ``/detail/`` part.

::

  https://www.example.com/list/title-of-single-item/


Installation
************

Use composer:

::

  composer require sourcebroker/singleview

Usage
*****

Each configuration of the singleview extension has to be registered in your ext_localconf.php file using
``\SourceBroker\Singleview\Service\SingleViewService::registerConfig`` static method as below.

::

    <?php
    \SourceBroker\Singleview\Service\SingleViewService::registerConfig(
        1,
        2,
        function() {
            $newsParams = \TYPO3\CMS\Core\Utility\GeneralUtility::_GET('tx_news_pi1');
            return !empty($newsParams['news']);
        },
        ['backend_layout'],
    );

Parameters:

1) First param is PID of the list view page.

2) Second param is PID of the single view page.

3) Third param is closure which returns boolean (or boolean value as a condition) which needs to be met to show
   single page on list view page. Closure is good here because at ext_localconf.php level the ext:realurl did not decoded
   yet the url so the value of \TYPO3\CMS\Core\Utility\GeneralUtility::_GET('tx_news_pi1') is empty. But at the place
   the closure is run the \TYPO3\CMS\Core\Utility\GeneralUtility::_GET('tx_news_pi1') will return good value.

4) Fourth param is optional and its array of strings with names of the fields which will be copied from single page
   to list page.

   If you use backend_layouts then probably you should put there ['backend_layout'] so at the page with list view
   the proper 'backend_layout' form single view will be shown.


**IMPORTANT!**

You must change the uid of page used to build single view links. It should point to list view page now.


Technical background
********************

The idea behind is to use TYPO3 build in feature "Show content from pid" which you can find in page properties. In this
extension value for "Show content from pid" field is set dynamically based on $_GET parameter. When TYPO3 renders page
with list view then ext:singleview checks if $_GET parameter has single view request. If this is true then it sets
"content_from_pid" field with value of single view page uid. This way single view page with its content and layout
is shown on list view page.

To be sure that TYPO3 will not use one cache for list view and single view a "content_from_pid" is added to hashBase.
You can deactivate this behaviour by setting:
``$GLOBALS['TYPO3_CONF_VARS']['EXT']['EXTCONF']['singleview']['hashBaseCustomization']['enabled'] = false;``

Changelog
*********

See https://github.com/sourcebroker/singleview/blob/master/CHANGELOG.rst
