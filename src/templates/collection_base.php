import { <?= $phpName; ?> } from '/../<?= $phpName; ?>'
import { Collection } from 'vue-mc'

/**
 * <?= $phpName; ?> collection
 */
class <?= $phpNamePlural; ?> extends Collection {

    // Model that is contained in this collection.
    model() {
        return <?= $phpName; ?>;
    }

    // Default attributes
    defaults() {
        return {
        }
    }

    // Route configuration
    routes() {
        return {
            <?php foreach($collectionRoutes as $name => $route) : ?>
            <?= $name; ?>: '<?= $route; ?>',
            <?php endforeach ?>
        }
    }
}