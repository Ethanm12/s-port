<script>
  export default {
    name: 'modal',
    methods: {
      close() {
        this.$emit('close');
      },
    },
  };
</script>
<template>
  <transition name="modal-fade">
    <div class="modal-backdrop">
      <div class="modal" role="dialog" aria-labelledby="modalTitle" aria-describedby="modalDescription">
        <header class="modal-header" id="modalTitle">
          <slot name="header"></slot>
          <button type="button" class="btn-x" @click="close" aria-label="Close modal">x</button>
          
        </header>
        <section class="modal-body" id="modalDescription">
          <slot name="body">

          </slot>
        </section>
        <footer class="modal-footer">
          <slot name="footer">
            <button type="button" class="btn-close" @click="close" aria-label="Close modal">Close</button>
          </slot>
        </footer>
      </div>
    </div>
  </transition>
</template>
<style>
  .modal-backdrop {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.3);
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    z-index: 1000;
  }

  .modal {
    width: 90%;
    max-width: 600px;
    height: 450px;
    left: 0;
    right: 0;
    margin: auto;
    background: #FFFF;
    box-shadow: 2px 2px 20px 1px;
    overflow-x: auto;
    display: flex;
    flex-direction: column;
  }

  .modal-header,
  .modal-footer {
    padding: 10px;
    display: flex;
    align-items: center;
  }

  .modal-header {
    border-bottom: 1px solid #eeeeee;
    color: #f7941d;
    justify-content: space-between;
  }
  .modal-header h2 {
    font-size: 18px;
    padding-left: 40px;
    margin: 0;
  }

  .modal-footer {
    margin-top: 0;
    border-top: 1px solid #eeeeee;
    justify-content: flex-end;
    padding: 25px;
  }

  .modal-body {
    position: relative;
    flex: 1;
  }

  .btn-x {
    border: none;
    font-size: 20px;
    padding: 10px 20px;
    cursor: pointer;
    font-weight: bold;
    color: #f7941d;
    background: transparent;
  }
  .btn-x:hover {
    color: #00629b;
  }

  .btn-close {
    color: white;
    background: #f7941d;
    border: 1px solid #f7941d;
    border-radius: 2px;
  }

  .btn-close:hover {
    background: #00629b;
    border: 1px solid #00629b;
  }
</style>
