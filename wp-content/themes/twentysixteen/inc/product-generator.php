<pre>
<?php

// We need more execetion time
set_time_limit(600);

define('PRODUCTS_COUNT', 500);
define('VERBOSE', false);

require $_SERVER['DOCUMENT_ROOT'] . '/wp-blog-header.php';
require $_SERVER['DOCUMENT_ROOT'] . '/wp-admin/includes/image.php';
require $_SERVER['DOCUMENT_ROOT'] . '/wp-admin/includes/file.php';
require $_SERVER['DOCUMENT_ROOT'] . '/wp-admin/includes/media.php';

echo 'PRODUCT GENERATOR' . PHP_EOL . PHP_EOL;

//Get taxonomies
$args = [
	'public'   => true,
	'_builtin' => false
];
$output = 'object';
$operator = 'and';
$taxonomies = get_taxonomies($args, $output, $operator);

$taxonomiesArray = [];

// Make taxonomies/terms dependency array
if(is_array($taxonomies)){
	foreach($taxonomies as $taxonomy){
		// Get this taxonomie term
		$terms = get_terms($taxonomy->name, ['hide_empty' => false]);
		if(is_array($terms)){
			foreach($terms as $term){
				$taxonomiesArray[$taxonomy->name][] = $term->slug;
			}
		}
	}
}

// Get custom fields for products
$acfGroupKey = 'group_60295708e652a'; // ACF group key
$customFields = acf_get_fields($acfGroupKey);

// Post array generator
$postData = [
	'post_type'     => 'product',
	'post_status'   => 'publish',
	'post_author'   => 1,
];

// Create 1000 products
for ($i = 1; $i <= PRODUCTS_COUNT ; $i++) { 

	$postData['post_title'] = 'Товар ' . uniqid();

	// Create product and get its ID
	$post_id = wp_insert_post(wp_slash($postData));
	if (VERBOSE) echo 'PRODUCT ID: ' . $post_id . PHP_EOL;
	// Iterate thru product taxonomies
	foreach ($taxonomiesArray as $taxonomyName => $taxonomyTerms) {
		// Get random taxonomy term
		$randomTaxonomyTerm = $taxonomyTerms[array_rand($taxonomyTerms)];
		$termObject  = get_term_by('slug', $randomTaxonomyTerm, $taxonomyName);
		// Update post with random terms
		wp_set_object_terms($post_id, $termObject->slug, $taxonomyName);
		if (VERBOSE) echo $taxonomyName . ': ' . $randomTaxonomyTerm . PHP_EOL;
	}

	// Iterate thru product custom fields
	foreach ($customFields as $key => $customField) {
		// Generate random value depending on custom field type
		switch ($customField['type']) {
			case 'number':
			case 'range':
				$value = generate_random_number($customField);
				break;
			case 'select':
				$value = generate_random_select($customField);
				break;
			case 'true_false':
				$value = generate_random_switch($customField);
				break;
		}
		// Update product custom field
		update_field($customField['ID'], $value, $post_id);
			

		if (VERBOSE && is_array($value)) $value = json_encode($value);
		if (VERBOSE) echo $customField['name'] . ': ' . $value . PHP_EOL;
	}
	
	//Generate featured image
	$isImageGenerated = generate_featured_image('https://picsum.photos/800/800.jpg', $post_id);
	if (VERBOSE) echo $isImageGenerated ? 'Image generated successfully' : 'Image generation fail';
	if (VERBOSE) echo PHP_EOL . PHP_EOL;
}

echo 'FINISHED...';

/**
 * Generate random number within range and step
 * @param array $customField 
 * @return float
 */
function generate_random_number(array $customField) : float
{
	$min = isset($customField['min']) && $customField['min'] ? $customField['min'] : 0;
	$max = isset($customField['max']) && $customField['max'] ? $customField['max'] : 9999.99;
	$step = isset($customField['step']) && $customField['step'] ? $customField['step'] : 1;

	$range = range($min, $max , $step);

	return (float)$range[array_rand($range)];
}

/**
 * Generate random selections
 * @param array $customField 
 * @return array
 */
function generate_random_select(array $customField) : array
{
	$choices = is_array($customField['choices']) && sizeof($customField['choices']) ? $customField['choices'] : ((isset($customField['default_value']) && isset($customField['default_value'][0]) && $customField['default_value'][0]) ? $customField['default_value'][0] : []) ;

	$maxElements = isset($customField['multiple']) && $customField['multiple'] && is_array($customField['choices']) ? sizeof($customField['choices']) : 1; 

	$numberOfElementsToChoose = rand(1, $maxElements);

	return (array)array_rand($choices, $numberOfElementsToChoose);
}

/**
 * Generate random switch position
 * @param array $customField 
 * @return bool
 */
function generate_random_switch(array $customField) : bool
{
	return (bool)rand(0, 1);
}

/**
* Downloads an image from the specified URL and attaches it to a post as a post thumbnail.
*
* @param string $file    The URL of the image to download.
* @param int    $post_id The post ID the post thumbnail is to be associated with.
* @return string|WP_Error Attachment ID, WP_Error object otherwise.
*/
function generate_featured_image($file, $post_id) : bool {
   // Set variables for storage, fix file filename for query strings.
    preg_match('/[^\?]+\.(jpe?g|jpe|gif|png)\b/i', $file, $matches);
    
    if (!$matches) {
         return false;
    }

    $file_array = [];

    $file_array['name'] = basename($matches[0]);

    // Download file to temp location
    $file_array['tmp_name'] = download_url($file);

    // If error storing temporarily, return false
    if (is_wp_error($file_array['tmp_name'])) {
        return false;
    }

    // Do the validation and storage stuff
    // Add define('ALLOW_UNFILTERED_UPLOADS', true); into wp-config.php to make it happen
    $id = media_handle_sideload($file_array, $post_id);

    // If error storing permanently, unlink and return false
    if (is_wp_error($id)) {
        @unlink($file_array['tmp_name']);
        return false;
    }

    return set_post_thumbnail($post_id, $id);

}

?>