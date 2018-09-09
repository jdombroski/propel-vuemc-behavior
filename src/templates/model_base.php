import { Model } from 'vue-mc'

/**
 * <?= $phpName; ?> model
 */
class <?= $phpName; ?> extends Model {

    // Default attributes that define the "empty" state.
    defaults() {
        return {
        <?php foreach($attributes as $attribute) : ?>
        <?= $attribute["name"]; ?>: <?= $attribute["defaultValue"]; ?>,
        <?php endforeach ?>
        }
    }

    // Attribute mutations.
    mutations() {
        return {
        }
    }

    // Attribute validation
    validation() {
        return {
        }
    }

    // Route configuration
    routes() {
        return {
            <?php foreach($modelRoutes as $name => $route) : ?>
            <?= $name; ?>: '<?= $route; ?>',
            <?php endforeach ?>
        }
    }
}