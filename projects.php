<?php


require_once 'vendor\autoload.php';

use app\Models\{ Job, Project };

$projects = Project::all();

  
function printProject($project) {
    /*if($job->visible == false) {
      return;
    }*/
  
    echo '<li class="work-position">';
    echo '<h5>' . $project->title . '</h5>';
    echo '<p>' . $project->description . '</p>';
    echo '<a href="' . $project->link . '" target="_blank">' . $project->link . '</a><br>';
    echo '<strong>Achievements:</strong>';
    echo '<ul>';
    echo '<li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>';
    echo '<li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>';
    echo '<li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>';
    echo '</ul>';
    echo '</li>';
  }