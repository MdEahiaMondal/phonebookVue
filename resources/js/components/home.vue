<template>
    <div class="columns">
        <div class="column is-three-fifths is-offset-one-fifth">
            <nav class="panel">
                <p class="panel-heading">
                    Repositories
                    <button class="button has-background-info" @click="addModal">
                        Add
                    </button>

                    <span class="pull-right" v-if="loading">
                        <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                        <span class="sr-only">Loading...</span>
                    </span>

                </p>
                <div class="panel-block">
                    <p class="control has-icons-left">
                        <input class="input" v-model="searchQuery" type="text" placeholder="Search">
                        <span class="icon is-left">
                            <i class="fas fa-search" aria-hidden="true"></i>
                        </span>
                    </p>
                </div>
                <a class="panel-block is-active" v-for="(data_list, index) in temp_data_lists">
                    <div class="column is-9">
                        {{ data_list .name }}
                    </div>
                    <div class="column is-1">
                        <i class="has-text-info fa fa-eye" aria-hidden="true" @click="showDetail(data_list)"></i>
                    </div>
                    <div class="column is-1">
                        <i class="has-text-primary fa fa-edit" aria-hidden="true" @click="showUpdateModal(data_list)"></i>
                    </div>
                    <div class="column is-1">
                        <i class="has-text-danger fa fa-trash" aria-hidden="true" @click="del(index, data_list.id)"></i>
                    </div>
                </a>
            </nav>
        </div>
        <modal :openmodal="modalShow" @addModalClose="modalClose" @dataSave="dataSave">
            <div class="field">
                <div class="control">
                    <label class="label">Name</label>
                    <input class="input" :class="{'is-danger' : errors.name}" type="text" v-model="lists.name"
                           placeholder="Text input">
                    <span v-if="errors.name" class="has-text-danger">{{ errors.name[0] }}</span>
                </div>
            </div>
            <div class="field">
                <div class="control">
                    <label class="label">Email</label>
                    <input class="input" type="email" :class="{'is-danger' : errors.email}" v-model="lists.email"
                           placeholder="Text input">
                    <span v-if="errors.email" class="has-text-danger">{{ errors.email[0] }}</span>
                </div>
            </div>
            <div class="field">
                <div class="control">
                    <label class="label">Phone</label>
                    <input class="input" :class="{'is-danger' : errors.phone}" type="text" v-model="lists.phone"
                           placeholder="Text input">
                    <span v-if="errors.phone" class="has-text-danger">{{ errors.phone[0] }}</span>
                </div>
            </div>
        </modal>

        <showDetails :openmodal="show_detailModalActive" @addModalClose="modalClose">
            <a class="panel-block">
                <label class="column is-2"><b>Name</b></label>
                {{ list.name }}
            </a>
            <a class="panel-block">
                <label class="column is-2"><b>Email</b></label>
                {{ list.email }}
            </a>
            <a class="panel-block">
                <label class="column is-2"><b>Phone</b></label>
                {{ list.phone }}
            </a>
        </showDetails>

        <update :openmodal="update_modal_show" @addModalClose="modalClose" @saveUpdatedata="updateData">
            <div class="field">
                <div class="control">
                    <label class="label">Name</label>
                    <input class="input" :class="{'is-danger' : errors.name}" type="text" v-model="lists.name"
                           placeholder="Text input">
                    <span v-if="errors.name" class="has-text-danger">{{ errors.name[0] }}</span>
                </div>
            </div>
            <div class="field">
                <div class="control">
                    <label class="label">Email</label>
                    <input class="input" type="email" :class="{'is-danger' : errors.email}" v-model="lists.email"
                           placeholder="Text input">
                    <span v-if="errors.email" class="has-text-danger">{{ errors.email[0] }}</span>
                </div>
            </div>
            <div class="field">
                <div class="control">
                    <label class="label">Phone</label>
                    <input class="input" :class="{'is-danger' : errors.phone}" type="text" v-model="lists.phone"
                           placeholder="Text input">
                    <span v-if="errors.phone" class="has-text-danger">{{ errors.phone[0] }}</span>
                </div>
            </div>
        </update>

    </div>
</template>

<script>
    import modal from "./modal";
    import showDetails from "./show_details";
    import update from "./update";

    export default {
        name: "home",
        data() {
            return {
                modalShow: '',
                show_detailModalActive: '',
                update_modal_show: '',
                lists: {
                    name: '',
                    email: '',
                    phone: '',
                },
                errors: {},
                data_lists: {},
                temp_data_lists: '',
                list: '',
                loading: false,
                searchQuery: ''
            }
        },
        watch:{
            searchQuery()
            {
               if (this.searchQuery.length > 0)
               {
                   this.temp_data_lists = this.data_lists.filter((item) => {
                       return  Object.keys(item).some(key => { // Object.key mains is all key get from this item array,, like id, name, email, created_at, updated_at
                          let string = String (item[key]);
                           return string.toLowerCase().indexOf(this.searchQuery.toLowerCase()) > -1;
                       })
                       /*return item.name.toLowerCase().indexOf(this.searchQuery.toLowerCase()) > -1;*/
                   })
               }else{
                   this.temp_data_lists = this.data_lists
               }
            }
        },
        mounted() {
           this.fatchData();
        },
        components: {
            modal, showDetails, update
        },
        methods: {
            addModal() {
                this.errors = ''
                this.modalShow = 'is-active'
            },
            modalClose() {
                this.errors = ''
                this.modalShow = this.show_detailModalActive = this.update_modal_show =  '';
            },
            dataSave() {
                axios.post('/phonebook', this.$data.lists).then(res => {
                    this.modalClose();
                    this.data_lists.push(res.data);

                    this.data_lists.sort(function (a, b) { // name order by asc
                        if (a.name > b.name)
                        {
                            return 1
                        }else if(b.name > a.name)
                        {
                            return -1
                        }
                    });
                    this.lists = ''
                })
                .catch(error => this.errors = error.response.data.errors)
            },
            showDetail(data_list) {
                this.show_detailModalActive = 'is-active'
                this.list = data_list;
            },
            showUpdateModal(data)
            {
                this.errors = ''
                this.update_modal_show = 'is-active'
                this.lists = data;
            },
            updateData()
            {
                axios.put(`/phonebook/${this.lists.id}`, this.$data.lists).then(res => this.modalClose())
                    .catch(error => this.errors = error.response.data.errors)
            },
            fatchData()
            {
                axios.post('/getData')
                    .then(res => this.data_lists = this.temp_data_lists = res.data)
                    .catch(error => console.log(error))
            },
            del(key, id)
            {

                if (confirm('Are you sure to delete ?'))
                {
                    this.loading = true
                    axios.delete(`/phonebook/${id}`).then(res => this.data_lists.splice(key, 1),this.temp_data_lists.splice(key, 1),   this.loading = false)
                        .catch(error =>  console.log(error))
                }else{
                    this.loading = false
                }

            }
        }
    }
</script>

<style scoped>

</style>
