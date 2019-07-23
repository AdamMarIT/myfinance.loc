<template>
<div class="file">
   <div class="col-sm-12">
      <h5>File upload</h5>
      <div class="row">
        <div class="col-sm-6">
          <b-form inline>
              <b-form-file
                v-model="file"
                :state="Boolean(file)"
                placeholder="Choose a file..."
                drop-placeholder="Drop file here..."
              ></b-form-file>
          </b-form>
        </div>
        <div class="col-sm-6">
          <b-button class=" mb-2 mr-sm-2 mb-sm-2" @click="Upload">Upload</b-button>
        </div>
      </div>
      <!-- box for uploaded files -->
      <h5>Uploaded files</h5>
      <div class="row inline" v-for="(file, index) in files" v-bind:key="index">
        <div class="col-sm-2 bg-file">
          {{file.date}}
        </div>
        <div class="col-sm-4 bg-file">
          {{file.name}}
        </div>
        <div class="col-sm-2 text-right">
          <b-button-group class="button-group">
            <b-button variant="info" v-on:click="openFile(file.id)">Open</b-button>
            <b-button variant="danger" v-on:click="deleteFile(file.id)">Delete</b-button>
          </b-button-group>
        </div>
      </div>
  </div>
</div>
</template>

<script>

export default {
    name: 'Files',

    data () {
      return {
        files: [],
        file: null,
      }
    },
    created() {
      this.showFiles()
    },

    methods: {
      showFiles() {
        this.$request.get('/api/auth/file_index')
            .then( response=> {
                this.files = response
            })
      },

      // Upload() {
      //   await this.$request.post('/api/auth/file_upload', {
      //     file: this.file,
      //   })
      //   .then( response=> {
      //     this.file = null
      //   })
      // },
    }
}

    
</script>

<style>
.file {
  text-align: left;
  margin-top: 20px
}

.inline div {
  display: inline-block;
  line-height: 2.5em; 
  
}

.bg-file {
  border-bottom: solid 1px #ccc;
}

</style>