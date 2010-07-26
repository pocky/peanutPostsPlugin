# ATTENTION #

Le plugin n'est pas encore complètement terminé mais est fonctionnel en l'état.

Le plugin requiert l'installation de [sfDoctrineActAsTaggablePlugin](http://www.symfony-project.org/plugins/sfDoctrineActAsTaggablePlugin)


# INFORMATION #

Ce plugin est optimisé pour le CMS [peanut](http://github.com/pocky/peanut) mais peut fonctionner indépendamment sur n'importe quel projet symfony. Le plugin utilise cependant l'admin-generator pour le backend alors pensez-y !

# INSTALLATION #

    $ git clone git://github.com/pocky/peanutPostsPlugin.git plugins/peanutPostsPlugin
    $ php symfony doctrine:build --all
    $ php symfony plugin:publish-assets
    $ php symfony cc

## Activer le plugin et ses modules ##

__Dans config/ProjectConfiguration.class.php__

    $this->enablePlugins(array(
      [...]
      'peanutPostsPlugin',
      'sfDoctrineActAsTaggablePlugin',
    ));

__Dans apps/backend/config/settings.yml__

    all:
      .settings:
        enabled_modules:        [default, ..., backendPosts, backendCategories, backendTag, taggableComplete]

__Dans apps/frontend/config/settings.yml__

    all:
      .settings:
        enabled_modules:        [post, category]

## Accéder aux modules ##

__Pour le backend (exemple)__

    <?php include_component('backendPosts', 'menu') ?>
    <?php include_component('backendCategories', 'menu') ?>
    <?php include_component('backendTag', 'menu') ?>

__Pour le frontend (exemple)__

    <?php include_component('category', 'menu') ?>`

