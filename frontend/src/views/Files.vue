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
          <b-button class=" mb-2 mr-sm-2 mb-sm-2" @click="upload">Upload</b-button>
        </div>
      </div>
      <p v-if="error" class="error">
        Error: {{ this.error }}
      </p>
      <!-- box for uploaded files -->
      <h5>Uploaded files</h5>
      <div class="row inline" v-for="(file, index) in files" v-bind:key="index">
        <div class="col-sm-1 text-right">
          {{ index + 1 }}
        </div>
        <div class="col-sm-3 text-left">
          {{file.name}}
        </div>
        <div class="col-sm-2">
          {{file.date}}
        </div>
        <div class="col-sm-4 text-left">
          <b-button-group class="button-group">
            <b-button variant="info" v-on:click="downloadFile(file)">Download</b-button>
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
        error: '',
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

      async upload() {
        const formData = new FormData()
        formData.append('file', this.file)

        await this.$request.post('/api/auth/file_upload', {
          file: formData,
          isFile: true,
        })
            .then( response=> {
              if (response.status == 'success') {
                this.file = null
                this.showFiles()
              } else {
                this.error = response.error
                setTimeout(() => this.error = '', 2000);
              }
            })
      },

      async deleteFile(id) {
        await this.$request.get("/api/auth/file_delete/"+id)
            .then( response=> {
              this.showFiles()
            })
      },

      downloadFile(file) {
        location.href = "http://myfinance.loc/api/file_download/"+file.id+'/'+file.link;
      },
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

.error {
  color: red;
}

</style>