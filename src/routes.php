<?php

return [
    ['GET', '/', ['Marsapi\Controllers\Photos', 'showPhotos']],
    ['GET', '/index.php', ['Marsapi\Controllers\Photos', 'showPhotos']],
    ['GET', '/photos/{rover}/{camera}/{dayRange}/{limit}', ['Marsapi\Controllers\Photos', 'showPhotos']],
];
