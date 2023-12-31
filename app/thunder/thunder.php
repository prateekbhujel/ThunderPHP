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
          $this->message("That plugin folder already exists: [$folder]",'error', true);

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
          $this->message("plugin sample file not found in: [".$plugin_file_source . "]", 'error', true);
        }

        /*controller file*/
        $controller_file = $folder . '/controllers/controller.php';
        $controller_file_source = 'app/thunder/samples/controller-sample.php';
        
        if(file_exists($controller_file_source)){
          copy($controller_file_source, $controller_file);
        }else{
          $this->message("controller sample file not found in: [".$controller_file_source . "]", 'error', true);
        }

        /*view file*/
        $view_file = $folder . '/views/view.php';
        $view_file_source = 'app/thunder/samples/view-sample.php';
        
        if(file_exists($view_file_source)){
          copy($view_file_source, $view_file);
        }else{
          $this->message("view sample file not found in: [".$view_file_source ."]", 'error', true);
        }
   
        /*js file*/
        $js_file = $folder . '/assets/js/plugin.js';
        $js_file_source = 'app/thunder/samples/js-sample.js';
        
        if(file_exists($js_file_source)){
          copy($js_file_source, $js_file);
        }else{
          $this->message("js sample file not found in: [".$js_file_source ."]", 'error', true);
        }

        /*css file*/
        $css_file = $folder . '/assets/css/style.css';
        $css_file_source = 'app/thunder/samples/css-sample.css';
        
        if(file_exists($css_file_source)){
          copy($css_file_source, $css_file);
        }else{
          $this->message("css sample file not found in: [".$css_file_source . "]", 'error', true);
        }
        
        /*config file*/
        $config_file = $folder . '/config.json';
        $config_file_source = 'app/thunder/samples/config-sample.json';
        
        if(file_exists($config_file_source)){
          copy($config_file_source, $config_file);
        }else{
          $this->message("config sample file not found in: [".$config_file_source . "]", 'error', true);
        }
   
        $this->message("Plugin creation complete! Plugin folder: [" . $folder . "]");  

      }else
      if($action == 'make:migration')
      {

        $original_folder = $folder;
        $folder = 'plugins/'.$folder . "/";

        if(!file_exists($folder))
          $this->message("Plugin folder was not found !", true);

        $migration_folder = $folder . "migrations/";
        if(!file_exists($migration_folder))
          mkdir($migration_folder,077,true);

        $file_sample = 'app/thunder/samples/migration-sample.php';
        
        if(!file_exists($file_sample))
          $this->message("Sample file for migration not found in: [" . $file_sample . "]", 'error', true);

        if(empty($class_name))
          $this->message("Classname cannot be empty. ", 'error', true); 

        $class_name = preg_replace("/[^a-zA-Z_\-]/", "", $class_name);
        $class_name = str_replace("-", "_", $class_name);
        $class_name = ucfirst($class_name);

        $table_name = strtolower($class_name);

        $content    = file_get_contents($file_sample);
        $content    = str_replace("{TABLE_NAME}", $table_name, $content);
        $content    = str_replace("{CLASS_NAME}", $class_name, $content);

        $filename   =  $migration_folder . date("Y-m-d_His_") . $table_name . ".php";
        file_put_contents($filename, $content);

        $this->message("Migration File Created ! Filename:" . "[$filename]", "info", true);

      }else
      if($action == 'make:model')
      {

        $original_folder = $folder;
        $folder = 'plugins/'.$folder . "/";

        if(!file_exists($folder))
          $this->message("Plugin folder was not found !", true);

        $model_folder = $folder . "models/";
        if(!file_exists($model_folder))
          mkdir($model_folder,077,true);

        $file_sample = 'app/thunder/samples/model-sample.php';
        
        if(!file_exists($file_sample))
          $this->message("Sample file for model not found in: [" . $file_sample . "]", 'error', true);

        if(empty($class_name))
          $this->message("Please provide a valid name for your model or cannot be empty. ", 'error', true); 

        $class_name = preg_replace("/[^a-zA-Z_\-]/", "", $class_name);
        $class_name = str_replace("-", "_", $class_name);
        $class_name = ucfirst($class_name);

        $table_name = strtolower($class_name);

        $content    = file_get_contents($file_sample);
        $content    = str_replace("{TABLE_NAME}", $table_name, $content);
        $content    = str_replace("{CLASS_NAME}", $class_name, $content);

        $filename   =  $model_folder . $class_name . ".php";
        file_put_contents($filename, $content);

        $this->message("Model File Created ! Filename:" . "[$filename]", "info", true);

      }else
      {
        $this->message("Unknown command ". $action);
      }
      
      
    }

    
    /**
     *  Migrates the 
    */
    public function migrate( array $args)
    {
        $action      = $args[1] ?? null;
        $folder      = $args[2] ?? null;
        $file_name   = $args[3] ?? null;


        if($action == 'migrate' || $action = 'migrate:rollback')
        {
          $folder = 'plugins/' . $folder . '/migrations/';

          if(!is_dir($folder))
              $this->message("No Migration File found in that location", 'error', true);

          if(!empty($file_name))
          {
              /** Run Single file from folder **/
              $file = $folder . $file_name;
             
              $this->message("Migrating file [ $file ]............................✔️ [DONE]", "info");
              
              require_once $file;

              $class_name = basename($file);
              preg_match("/[a-zA-Z]+\.php$/", $class_name, $match);
              $class_name = ucfirst(str_replace(".php", "", $match[0]));

              $myClass = new ("\Migration\\$class_name");

              if($action == 'migrate')
              { 
                  $myClass->up();

              }else
              {
                  $myClass->down();
              }
              
              $this->message("Migration Complete", 'success', true); 
              $this->message("File: " . $file_name, "info", true);
          
          }else
          {
            /** Get all files from folder **/
            $files = glob($folder . "*.php");

            if(!empty($files))
            {

                foreach($files as $file) 
                {
                    $this->message("Migrating file [ $file ]............................✔️ [DONE]", "info");
                    require_once $file;


                    $class_name = basename($file);
                    preg_match("/[a-zA-Z]+\.php$/", $class_name, $match);
                    $class_name = ucfirst(str_replace(".php", "", $match[0]));

                    $myClass = new ("\Migration\\$class_name");

                    if($action == 'migrate')
                    { 
                        $myClass->up();

                    }else
                    {
                        $myClass->down();
                    }

                }

                $this->message("Migration Complete", 'success', true); 

            }else
            {
                $this->message("No Migration File found in specified folder", 'error', true); 
            }
          }

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
          $color = "\033[44;37m"; // Blue color for Model messages
      } elseif ($type === 'model') {
          $color = "\033[43;37m"; // Yellow color for Migration messages
      }

      $resetColor = "\033[0m"; // Reset color after the message

      $output = "\n\r " . $color . ucfirst($type) . ':' . $resetColor . ' ' . ucfirst($message)  . " \n";

      echo $output;
      ob_flush();

      if($die) 
        die();
  }

}
