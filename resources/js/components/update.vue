<template>
    <div class="modal" :class="openmodal">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Update Item</p>
                <button class="delete" aria-label="close"  @click="closeModal"></button>
            </header>
            <section class="modal-card-body">
                <slot></slot>
            </section>
            <footer class="modal-card-foot">
                <button class="button is-success" @click="saveUpdatedata" >Save</button>
                <button class="button" @click="closeModal">Cancel</button>
            </footer>
        </div>
    </div>
</template>

<script>
    export default {
        name: "update",
        props: ['openmodal'],
        methods: {
            closeModal()
            {
                this.$emit('addModalClose')
            },
            saveUpdatedata()
            {
                this.$emit('saveUpdatedata')
            }
        }
    }
</script>

<style scoped>

</style>
