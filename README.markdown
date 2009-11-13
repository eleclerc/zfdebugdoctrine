# Doctrine ORM with Zend Framedwork and ZFDebug

This is a proof of concept to have Doctrine data in a ZFDebug panel. My Doctrine plugin for ZFDebug is at:
  
    library/Danceric/Controller/Plugin/Debug/Plugin/Doctrine.php 

To try this demo project, you need to put these libs in the `library` folder (or in your php include path)

- [Zend Framework](http://framework.zend.com/) 1.9.x
- [ZFDebug](http://code.google.com/p/zfdebug/) 1.5.x
- [Doctrine](http://www.doctrine-project.org/) (Doctrine AND vendor folder) 1.2.x

It should look like:

    library/
      Danceric/
      Doctrine/
      vendor/
      ZFDebug/
      Zend/

If you use the sqlite database, make sure that it is readable/writable by the web server

## More about ZF and Doctrine

For more information, see these blog posts:

- [Doctrine 1.2 is Zend Framework friendly](http://www.danceric.net/2009/10/29/doctrine-1-2-is-zend-framework-friendly/)
- [Doctrine ORM (1.1) and Zend Framework](http://www.danceric.net/2009/06/06/doctrine-orm-and-zend-framework/)
- [ZFDebug (1.5) and Doctrine ORM (1.1)](http://www.danceric.net/2009/06/06/zfdebug-and-doctrine-orm)
