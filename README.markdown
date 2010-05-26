*as of 2010-05-26, all the stuff about integrating Doctrine and Zend Framework have been removed as there is now a semi-official ZFDoctrine project, see the [announcement](http://zend-framework-community.634137.n4.nabble.com/Release-of-the-ZF-Doctrine-1-Integration-tp2227907p2227907.html)*

# Doctrine panel for ZFDebug

This is a proof of concept to have Doctrine data in a ZFDebug panel for Zend Framework. 

## Usage

You have to put `Danceric` folder in you `library` folder (if you're using the default ZF layout)
and enable it at the 
[configuration step] (http://code.google.com/p/zfdebug/wiki/Installation) of [ZFDebug](http://code.google.com/p/zfdebug)

Example:

    $options = array(
        'plugins' => array('Variables',
        'Danceric_Controller_Plugin_Debug_Plugin_Doctrine',
        'File',
        'Memory',
        'Time',
        'Exception'),
    );
    $debug = new ZFDebug_Controller_Plugin_Debug($options);
    
## Before the semi-official zf-doctrine

If you're not using ZFDoctrine for any reason, you might want to see my sample project by looking at the [zfdebugdoctrine/Doctrine-1.2-beta](http://github.com/danceric/zfdebugdoctrine/tree/Doctrine-1.2-beta) tag. Keep in mind that it is not the supported way anymore though.