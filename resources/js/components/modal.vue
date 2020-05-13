<template>
    <div class="modal" :class="openmodal">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Add new Item</p>
                <button class="delete" aria-label="close"  @click="closeModal"></button>
            </header>
            <section class="modal-card-body">
              <slot></slot>
            </section>
            <footer class="modal-card-foot">
                <button class="button is-success" @click="saveData" >Save</button>
                <button class="button" @click="closeModal">Cancel</button>
            </footer>
        </div>
    </div>
</template>

<script>
    export default {
        name: "modal",
        props: ['openmodal'],
        methods: {
            closeModal()
            {
                this.$emit('addModalClose')
            },
            saveData()
            {
                this.$emit('dataSave')
            }
        }
    }
</script>

<style scoped>

</style>
