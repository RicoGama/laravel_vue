import {Category} from './resources';

export class CategoryFormat {

    static getCategoriesFormatted(categories) {
        let categoriesFormatted = this._formatCategories(categories);
        categoriesFormatted.unshift({
            id: 0,
            text: 'Nenhuma categoria',
            level: 0,
            hasChildren: false
        });
        return categoriesFormatted;
    }

    static _formatCategories(categories, categoryCollection = []) {
        for (let category of categories) {
            let categoryNew = {
                id: category.id,
                text: category.name,
                level: category.depth,
                hasChildren: category.children.data.length > 0
            };
            categoryCollection.push(categoryNew);
            this._formatCategories(category.children.data, categoryCollection);
        }
        return categoryCollection;
    }
}

export class CategoryService {

    static new(category, parent, categories) {
        let categoryCopy = $.extend(true, {}, category);
        if (categoryCopy.parent_id === null) {
            delete categoryCopy.parent_id;
        }
        return Category.save(categoryCopy).then(response => {
            let categoryAdded = response.data.data;
            if (categoryAdded.parent_id === null) {
                categories.push(categoryAdded);
            } else {
                parent.children.data.push(categoryAdded);
            }
            return response;
        });
    }
}