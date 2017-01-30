<template>
    <div class="row">
        <page-title>
            <h5>Administração de categorias</h5>
        </page-title>
        <div class="card-panel z-depth-5">
            <select-material :options="options" :selected="selected"></select-material>
            <category-tree :categories="categories"></category-tree>
        </div>

        <category-save :modal-options="modalOptionsSave" :category.sync="categorySave" @save-category="saveCategory">
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
    import SelectMaterial from '../../../../_default/components/SelectMaterial.vue';

    export default {
        components: {
            'page-title': PageTitleComponent,
            'category-tree': CategoryTreeComponent,
            'category-save': CategorySaveComponent,
            'select-material': SelectMaterial
        },
        data() {
            return {
                categories: [],
                categorySave: {
                    id: 0,
                    name: '',
                    parent_id: 0
                },
                title: 'Adicionar categoria',
                modalOptionsSave: {
                    id: 'modal-category-save'
                },
                options: {
                    data: [
                        {id: 1, text: 'Valor 1'},
                        {id: 2, text: 'Valor 2'},
                        {id: 3, text: 'Valor 3'},
                        {id: 4, text: 'Valor 4'},
                        {id: 5, text: 'Valor 5'},
                    ]
                },
                selected: 5,
            }
        },
        created() {
            this.getCategories();
        },
        methods: {
            getCategories() {
                Category.query().then(response => {
                    this.categories = response.data.data;
                });
            },
            saveCategory(){
                console.log('teste');
            },
            modalNew(category) {
                this.categorySave = category;
                $(`#${this.modalOptionsSave.id}`).modal('open');
            },
            modalEdit(category) {

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