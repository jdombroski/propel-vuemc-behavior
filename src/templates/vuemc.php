import {Model, Collection} from 'vue-mc'

/**
 * <?= $phpName; ?> model
 */
class <?= $phpName; ?> extends Model {

    // Default attributes that define the "empty" state.
    defaults() {
        return {
            <?php foreach($attributes as $attribute) : ?>
            <?= $attribute["name"]; ?>:   <?= $attribute["defaultValue"]; ?>,
            <?php endforeach ?>
        }
    }

    // Attribute mutations.
    mutations() {
        return {
            id:   (id) => Number(id) || null,
            name: String,
            done: Boolean,
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
            orderBy: 'name',
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