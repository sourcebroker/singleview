TYPO3 Extension ``singleview``
#############################

  .. image:: https://poser.pugx.org/sourcebroker/singleview/v/stable
    :target: https://packagist.org/packages/sourcebroker/singleview

  .. image:: https://poser.pugx.org/sourcebroker/singleview/license
    :target: https://packagist.org/packages/sourcebroker/singleview

.. contents:: :local:


What does it do?
****************

This extension allows to **display single view on different page than list view** and still keep urls user and SEO friendly.

Look at example below for better understanding.

Lets take following list view url:

::

  https://www.example.com/list/

TYPO3 default is that when you put single view on different page then there is no easy way to remove it
from slugified url. You will get something like below (single view is on separate page named "detail"):

::

  https://www.example.com/list/detail/title-of-single-item/

If you will use ``ext:singleview`` then you can put single view on different page than list view but the slugified
url will still look nice like below - so no ``/detail/`` part.

::

  https://www.example.com/list/title-of-single-item/


Installation
************

Use composer:

::

  composer require sourcebroker/singleview

Usage
*****

Each configuration of the ext:singleview settings has to be registered in your ext_localconf.php file using
``\SourceBroker\Singleview\Service\SingleViewService::registerConfig()`` static method as in example below (for ext:news)

::

    <?php

    use Psr\Http\Message\ServerRequestInterface;
    use TYPO3\CMS\Core\Routing\PageArguments;

    \SourceBroker\Singleview\Service\SingleViewService::registerConfig(
        1,
        2,
        static function (ServerRequestInterface $request): bool {
            $pageArguments = $request->getAttribute('routing');
            if (!$pageArguments instanceof PageArguments) {
                return false;
            }

            $newsParams = $pageArguments->get('tx_news_pi1') ?? [];
            return is_array($newsParams) && !empty($newsParams['news']);
        },
        ['backend_layout'],
    );

Parameters of registerConfig() method:

1) First param is PID of the list view page.

2) Second param is PID of the single view page.

3) Third param is closure which returns boolean (or boolean value as a condition) which needs to be met to show
   single page on list view page. Closure is good here because at ext_localconf.php level the url/slug is not decoded
   yet so the request arguments are not available. The closure receives the current request as first argument,
   so resolved frontend arguments can be read from the ``routing`` request attribute, which contains a
   ``TYPO3\CMS\Core\Routing\PageArguments`` instance.

   Use ``PageArguments::get()`` or ``PageArguments::getArguments()`` for values handled by TYPO3 route enhancers.
   ``$request->getQueryParams()`` contains parameters supplied directly in the URL query string and may not contain
   values decoded from a slug. Using ``PageArguments`` also makes route arguments take precedence if the same argument
   is additionally supplied in the query string.

4) Fourth param is optional and its array of strings with names of the fields which will be copied from single page
   to list page. If you use backend_layouts for managing your layouts then probably you should put there ['backend_layout']

5) Fifth param is an optional string or closure used as an additional page cache discriminator. The closure receives
   the current ``ServerRequestInterface`` as its first argument. Use it when the rendered variant depends on a value
   which is not already included in TYPO3's page cache identifier. For example:

   ::

       static function (ServerRequestInterface $request): string {
           $pageArguments = $request->getAttribute('routing');
           if (!$pageArguments instanceof PageArguments) {
               return '';
           }

           $newsParams = $pageArguments->get('tx_news_pi1') ?? [];
           $newsUid = is_array($newsParams) ? (int)($newsParams['news'] ?? 0) : 0;

           return $newsUid > 0 ? 'news:' . $newsUid : '';
       }

   Route arguments already included by TYPO3 do not normally need to be repeated here. Do not use the complete query
   string, cookies or user-specific values as the hash base. User-specific output should not use the shared page cache.


**IMPORTANT!**

Single view links should point to the same page uid as list view.


Technical background
********************

The idea behind is to use TYPO3 build in feature "Show content from pid" which you can find in page properties. In this
extension value for "Show content from pid" field is set dynamically based on request parameters. When TYPO3 renders page
with list view then ext:singleview checks if request parameters have single view request. If this is true then it sets
"content_from_pid" field with value of single view page uid. This way single view page with its content and layout
is shown on list view page.

To be sure that TYPO3 will not use one cache for list view and single view a "content_from_pid" is added to hashBase.
You can deactivate this behaviour by setting:
``$GLOBALS['TYPO3_CONF_VARS']['EXT']['EXTCONF']['singleview']['hashBaseCustomization']['enabled'] = false;``

Changelog
*********

See https://github.com/sourcebroker/singleview/blob/master/CHANGELOG.rst
