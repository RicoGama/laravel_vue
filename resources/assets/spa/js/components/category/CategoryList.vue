<template>
    <div class="row">
        <page-title>
            <h5>Administração de categorias</h5>
        </page-title>
        <div class="card-panel z-depth-5">
            <category-tree :categories="categories"></category-tree>
        </div>

        <category-save :modal-options="modalOptionsSave"
                       :category.sync="categorySave"
                       :cp-options="cpOptions"
                       @save-category="saveCategory">
            <span slot="title">{{ title }}</span>
            <div slot="footer">
                <button type="submit" class="btn btn-flat waves-effects green lighten-2 modal-close modal-action">
                    OK
                </button>
                <button class="btn btn-flat waves-effects waves-red modal-close modal-action">Cancelar</button>
            </div>
        </category-save>
    </div>
</template>

<script type="text/javascript">
    import PageTitleComponent from '../PageTitle.vue';
    import CategoryTreeComponent from './CategoryTree.vue';
    import CategorySaveComponent from './CategorySave.vue';
    import {Category} from '../../services/resources';
    import {CategoryFormat} from '../../services/category-nsm';

    export default {
        components: {
            'page-title': PageTitleComponent,
            'category-tree': CategoryTreeComponent,
            'category-save': CategorySaveComponent,
        },
        data() {
            return {
                categories: [],
                categoriesFormatted: [],
                categorySave: {
                    id: 0,
                    name: '',
                    parent_id: 0
                },
                title: 'Adicionar categoria',
                modalOptionsSave: {
                    id: 'modal-category-save'
                },
                selected: 5,
            }
        },
        computed: {
            // opções para o campo select2 de categoria pai
            cpOptions() {
                return {
                    data: this.categoriesFormatted,
                    templateResult(category) {
                        let margin = '&nbsp;'.repeat(category.level * 6);
                        let text = category.hasChildren ? `<strong>${category.text}</strong>` : category.text;
                        return `${margin}${text}`;
                    },
                    escapeMarkup(m) {
                        return m;
                    }
                }
            }
        },
        created() {
            this.getCategories();
        },
        methods: {
            getCategories() {
                Category.query().then(response => {
                    this.categories = response.data.data;
                    this.formatCategories();
                })
            },
            saveCategory(){
                //console.log('teste');
            },
            modalNew(category) {
                this.categorySave = category;
                $(`#${this.modalOptionsSave.id}`).modal('open');
            },
            modalEdit(category) {

            },
            formatCategories() {
                this.categoriesFormatted = CategoryFormat.getCategoriesFormatted(this.categories);
            }
        },
        events: {
            'category-new'(category) {
                this.modalNew(category);
            },
            'category-edit'(category) {

            }
        }
    }
</script>