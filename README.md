hoopss.beta.codeigniter (Hoopss 2.0)

**IMPORTANT!!!
This version is built in Codeigniter 2.1.2. It will cause a lot of problems with higher PHP versions so,**

1. **Use this only with PHP 5.4**
2. **If you want to use this with higher PHP versions, upgrade this to Codeigniter 3.1.3 or higher for compatibility.**

**I do not have time to upgrade Codeigniter and since I am working on Laravel 5.4 version of Hoopss, I will not maintain this Hoopss version and repo with Codeigniter 2.1.2. New version of Hoopss (3.0) will be based on Laravel 5.4 and in development right now.**


Hoopss is a specialized search engine which collects links from open directories by use of it's bots and serve them in a search environment. Hoopss have search criterias as music, document, video, archive, image, android and torrent.

For Sphinx Search to work you should download Sphinx search engine for your system and install as required. I had installed it from the .deb file for my ubuntu server (at which hoopss works http://www.hoopss.com) and for deb file sphinx.conf goes under /etc/sphinxsearch/ directory. There will be a sample config file as well so rename that sample config file and put sphinx.conf for hoopss which is located under application/third_party/sphinxsearch/config/ directory.

You can download Sphinx Search Engine from http://sphinxsearch.com/downloads/release/ and you can find documentation from http://sphinxsearch.com/docs/.
I advice you to read the documentation carefully before you install Sphinx and editing sphinx.conf

There is a revision of Hoopss which sphinx does not required (the first revision it is) so if you wish you can checkout that revision if you don't want to use Sphinx Search but you will probably experince the problems that I had experienced with big data: Deadly slow queries. (With big data I mean more than 2.5M working link record (and there are not working ones as well in my database for to use for keyword parse and statistical purposes) and I had managed to take query time down to 7s from 30s by using CodeIgniter cache mechanism plus Mysql cache. Before Sphinx with CodeIgniter caching it was 7s for a new query and it was under 1s with cached query results. With Sphinx all queries gives results instantly. You can check it from http://www.hoopss.com (NOTE: Since my old server closed, sphinx search is disabled temproraly for http://www.hoopss.com. I am trying to get a new VPS for to use sphinx again).
So I strongly advice you to use Sphinx Search added version of Hoopss for very very much better speed and morale :)

You should edit application/config/database.php file for your database name, database user and password. You will find the hoopss.sql dump (no record in it) in sql directory. You should add a user to the users table by hand if you want to test user login but user login is buggy right now and I don't advice you to use it.

For the future:
- I was working on Last.fm scrobing integration once but since Last.fm stop giving radio service to my country I stop coding that but I guess I will code the integration in the future.
- Users login, profiles and chatting will be added in the near future as well.
- There may be a social network or microblogging mechanism but I really don't want to work on what had done before (facebook, twitter and so many others exists).
- I had coded a youtube section in the past for people to find what they searched in music if they cannot find it in OpenDirectory Search (main search aim for Hoopss) but I had given up it. For now I had 400K youtube link indexed but not using them. Instead when I removed youtube I added image, android and torrent searches (image search may be removed in future revisions) aiming both android (apk) and torrent file searchs are more helping to people.
