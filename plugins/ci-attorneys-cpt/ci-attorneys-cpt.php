<?php
/*
Plugin Name: Attorneys Custom Post Type
Plugin URI: http://conversioninsights.net
Description: Adds an "Attorneys" post type to be used in the theme.
Version: 1.03
Author: Tyler Young
Author URI: http://conversioninsights.net
*/

require_once 'plugin-updates/plugin-update-checker.php';
require_once 'lib/constants.php';
require_once 'lib/utils.php';
require_once 'lib/createAttorneyType.php';
require_once 'lib/displayAttorneyType.php';

$UpdateChecker =
    PucFactory::buildUpdateChecker(
              'http://conversioninsights.net/downloads/plugins/attorneys-cpt_version_metadata.json',
              __FILE__,
              'ci-attorneys-cpt',
              720 // check once a month for updates -- 720 == 24*30
    );






