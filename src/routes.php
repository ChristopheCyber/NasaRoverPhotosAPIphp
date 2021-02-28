<?php

return [
    ['GET', '/', ['Marsapi\Controllers\Photos', 'showPhotos']],
    ['GET', '/index.php', ['Marsapi\Controllers\Photos', 'showPhotos']],
    ['GET', '/photos/{rover}/{camera}/{dayRange}/{max_pics}', ['Marsapi\Controllers\Photos', 'showPhotos']],
];
