<?php

namespace Thunder;

defined('FCPATH') or die('Direct script access denied.');

/**
 * Thunder Class
 */
class Thunder
{
    
  /**
   * Execute a specific Thunder command with the provided arguments.
   *
   * @param array $args An array of command-line arguments.
   */
    public function make(array $args)
    {

      $action     = $args[1] ?? null;
      $folder     = $args[2] ?? null;
      $class_name   = $args[3] ?? null;

      if($action == 'make:plugin')
      {
        $original_folder = $folder;
        $folder = 'plugins/'.$folder;

        if(file_exists($folder))
          $this->message("That plugin folder already exists",true);

        /*main plugin folder*/
        mkdir($folder,0777,true);

        $css_folder = $folder . '/assets/css/';
        mkdir($css_folder,0777,true);

        $js_folder = $folder . '/assets/js/';
        mkdir($js_folder,0777,true);

        $fonts_folder = $folder . '/assets/fonts/';
        mkdir($fonts_folder,0777,true);

        $images_folder = $folder . '/assets/images/';
        mkdir($images_folder,0777,true);

        $controller_folder = $folder . '/controllers/';
        mkdir($controller_folder,0777,true);
        
        $view_folder = $folder . '/views/';
        mkdir($view_folder,0777,true);
        
        $migration_folder = $folder . '/migrations/';
        mkdir($migration_folder,0777,true);
        
        $models_folder = $folder . '/models/';
        mkdir($models_folder,0777,true);

        /*copy files*/
        
        /*plugin file*/
        $plugin_file = $folder . '/plugin.php';
        $plugin_file_source = 'app/thunder/samples/plugin-sample.php';
        
        if(file_exists($plugin_file_source)){
          copy($plugin_file_source, $plugin_file);
        }else{
          $this->message("plugin sample file not found in: ".$plugin_file_source);
        }

        /*controller file*/
        $controller_file = $folder . '/controllers/controller.php';
        $controller_file_source = 'app/thunder/samples/controller-sample.php';
        
        if(file_exists($controller_file_source)){
          copy($controller_file_source, $controller_file);
        }else{
          $this->message("controller sample file not found in: ".$controller_file_source);
        }

        /*view file*/
        $view_file = $folder . '/views/view.php';
        $view_file_source = 'app/thunder/samples/view-sample.php';
        
        if(file_exists($view_file_source)){
          copy($view_file_source, $view_file);
        }else{
          $this->message("view sample file not found in: ".$view_file_source);
        }
   
        /*js file*/
        $js_file = $folder . '/assets/js/plugin.js';
        $js_file_source = 'app/thunder/samples/js-sample.js';
        
        if(file_exists($js_file_source)){
          copy($js_file_source, $js_file);
        }else{
          $this->message("js sample file not found in: ".$js_file_source);
        }

        /*css file*/
        $css_file = $folder . '/assets/css/style.css';
        $css_file_source = 'app/thunder/samples/css-sample.css';
        
        if(file_exists($css_file_source)){
          copy($css_file_source, $css_file);
        }else{
          $this->message("css sample file not found in: ".$css_file_source);
        }
        
        /*config file*/
        $config_file = $folder . '/config.json';
        $config_file_source = 'app/thunder/samples/config-sample.json';
        
        if(file_exists($config_file_source)){
          copy($config_file_source, $config_file);
        }else{
          $this->message("config sample file not found in: ".$config_file_source);
        }
   
        $this->message("Plugin creation complete! Plugin folder: ".$folder);  

      }else
      if($action == 'make:migration')
      {

      }else
      if($action == 'make:model')
      {

      }else
      {
        $this->message("Unknown command ". $action);
      }
      
      
    }


    /**
     * Display help information for the ThunderPHP CLI tool with the provided version.
     *
     * @param string and array $version The ThunderPHP version.
     */
    public function help(string|array $version): void
    {
      $version = is_array($version) ? $version[0] : $version;

        echo "

    ThunderPHP v$version Command Line Tool

    Database
      migrate            =  Locates and runs a migration from the specific plugin folder.
      migrate:refresh    =  Rolls back followed by the latest migration to refresh the current database state.
      migrate:rollback   =  Runs the 'down' method for a migration in the specified plugin folder.

    Generators
      make:plugin        =  Generates a new folder with all essential plugin files.
      make:migration     =  Generates a new migration file for the specified plugin folder.
      make:model         =  Generates a new model file.

        ";
    }


  /**
   * Display a message to the user and optionally terminate the script.
   *
   * @param string $message The message to be displayed.
   * @param string $type The type of message (e.g., 'success', 'error', 'migration', 'model').
   */
  private function message(string $message, string $type = 'success', bool $die = false): void
  {
      $color = "\033[42;37m"; // Default color for Success messages

      if ($type === 'error') {
          $color = "\033[41;37m"; // Red color for Error messages
      } elseif ($type === 'info') {
          $color = "\033[44;37m"; // Blue color for Migration messages
      } elseif ($type === 'model') {
          $color = "\033[43;37m"; // Yellow color for Model messages
      }

      $resetColor = "\033[0m"; // Reset color after the message

      $output = "\n\r " . $color . ucfirst($type) . ':' . $resetColor . ' ' . ucfirst($message)  . " \n";

      echo $output;
      ob_flush();

      if($die) 
        die();
  }

}
