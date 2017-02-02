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

    static edit(category, parent, categories, categoryOriginal) {
        let categoryCopy = $.extend(true, {}, category);
        if (categoryCopy.parent_id === null) {
            delete categoryCopy.parent_id;
        }
        let self = this;
        return Category.update({id: categoryCopy.id}, categoryCopy).then(response => {
            let categoryUpdated = response.data.data;
            if (categoryUpdated.parent_id === null) {
                /**
                 * Categoria alterada, está sem pai
                 * E antes ela tinha um pai
                 */
                if (parent) {
                    parent.children.data.$remove(categoryOriginal);
                    categories.push(categoryUpdated);
                    return response;
                }
            } else {
                /**
                 * Categoria alterada, tem pai
                 */
                if (parent) {
                    /**
                     * Trocar categoria de pai
                     */
                    if (parent_id != categoryUpdated.parent_id) {
                        parent.children.data.$remove(categoryOriginal);
                        self._addChild(categoryUpdated, categories);
                        return response;
                    }
                } else {
                    /**
                     * Tornar a categoria um filho
                     * Antes a categoria era um pai
                     */
                    categories.$remove(categoryOriginal);
                    self._addChild(categoryUpdated, categories);
                    return response;
                }
            }
            return response;
        });
    }

    static _addChild(child, categories) {
        let parent = this._findParent(child.parent_id, categories);
        parent.children.data.push(child);
    }

    static _findParent(id, categories) {
        for (let category of categories) {
            if (id == category.id) {
                return category;
            }
            return this._findParent(id, category.children.data);
        }
    }
}