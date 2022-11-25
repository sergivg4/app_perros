<template>

    <div class="container">
        
        <div class="row featurette" v-if="infoMode">
          <div class="col-md-7">
            <h2 class="featurette-heading">{{addData.raza}}</h2>
            <p class="lead">{{addData.descripcion}}</p>
            <button class="btn btn-danger" v-on:click="cancelInfoPerro()">Volver</button>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto" :src="'storage/'+addData.imagen" style="width: 500px;">
          </div>
        </div>

        <div v-else>

            <h2>Tabla de perros</h2>
        
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Raza</th>
                        <th scope="col">Descripcion</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="models in model.data">
                    <th scope="row">{{models.id}}</th>
                        <td>{{models.raza}}</td>
                        <td>{{models.descripcion}}</td>
                        <td>
                            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                <div class="btn-group mr-2" role="group" aria-label="First group">
                                    <button class="btn btn-success btn-sm" v-on:click="showInfoPerro(models)">Información</button>
                                </div>
                                <div class="btn-group mr-2" role="group" aria-label="Second group">
                                    <button class="btn btn-primary btn-sm" v-on:click="showEditForm(models)">Editar</button>
                                </div>
                                <div class="btn-group" role="group" aria-label="Third group">
                                    <button class="btn btn-danger btn-sm" v-on:click="removePerro(models)">Eliminar</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <br>

            <form v-on:submit.prevent="addPerro()" v-if="!editMode" enctype="multipart/form-data">
                
                <h2>Añadir perro</h2>

                <div class="form-group">
                    <input type="text" class="form-control" placeholder="raza" name="raza" v-model="addData.raza"/>
                </div>
                
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="descripcion" name="descripcion" v-model="addData.descripcion"/>
                </div>

                <div class="form-group">
                    <label for="imagen">Imagen</label>
                    <input type="file" class="file-upload" placeholder="imagen" name="imagen" v-on:change="getImage"/>
                </div>

                <figure>
                    <img width="200" height="200" :src="imagen" alt="Foto del perro">
                </figure>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>

            <form v-on:submit.prevent="editPerro(addData)" v-else>
                
                <h2>Editar perro</h2>

                <div class="form-group">
                    <input type="text" class="form-control" placeholder="raza" name="raza" v-model="addData.raza"/>
                </div>
                
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="descripcion" name="descripcion" v-model="addData.descripcion"/>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button class="btn btn-danger" v-on:click="cancelEditForm()">Cancelar</button>
                </div>
            </form>

        </div>

    </div>
</template>

<script>

import axios from 'axios'

    export default{
        data(){
            return {
                model:{},
                thumbnail: '',
                addData: {'raza':'', 'descripcion':'', 'imagen':''},
                editMode: false,
                infoMode: false
            }
        },
        created: function(){
            this.fetchDataPerro()
        },
        methods: {
            fetchDataPerro(){
                var vm = this
                axios.get('api/perro')
                    .then(function (response) {
                        Vue.set(vm.$data, 'model', response.data.model);
                        //console.log(response.data.model.data);
                    })
            },
            addPerro(){
                var vm = this
                var dataInput = vm.addData

                let formData = new FormData();
                formData.append('raza',this.addData.raza);
                formData.append('descripcion',this.addData.descripcion);
                formData.append('imagen',this.addData.imagen);

                axios.post('api/perro/add', formData)
                    .then(function (response) {
                        vm.addData={'raza':'','descripcion':'', 'imagen':''}
                        //console.log('success');
                        console.log(response.data);
                    })
                this.fetchDataPerro();this.fetchDataPerro();
            },
            showEditForm(data){
                this.editMode = true
                this.addData.raza = data.raza;
                this.addData.descripcion = data.descripcion;
                this.addData.imagen = data.imagen;
                //console.log(this.editMode);
            },
            cancelEditForm(){
                this.editMode = false
                this.addData.raza = '';
                this.addData.descripcion = '';
                this.addData.imagen = data.imagen;
                //console.log(this.editMode);
            },
            showInfoPerro(data){
                this.infoMode = true
                this.addData.raza = data.raza;
                this.addData.descripcion = data.descripcion;
                this.addData.imagen = data.imagen;
                //console.log(this.editMode);
            },
            cancelInfoPerro(){
                this.infoMode = false
                this.addData.raza = '';
                this.addData.descripcion = '';
                this.addData.imagen = data.imagen;
                //console.log(this.editMode);
            },
            editPerro(data){
                //console.log(data)
                axios.post('api/perro/edit/', data)
                this.editMode = false
                this.fetchDataPerro();
            },
            removePerro(data){
                //console.log(data.id)
                axios.post('api/perro/remove/', data)
                
                this.fetchDataPerro();
            },
            getImage(e){
                let file = e.target.files[0];
                    //console.log(file);
                this.addData.imagen = file;
                this.loadImage(file);
            },
            loadImage(file){
                let reader = new FileReader();

                reader.onload = (e) => {
                    this.thumbnail = e.target.result;
                }

                reader.readAsDataURL(file);
            }
        },
        computed: {
            imagen(){
                return this.thumbnail;
            }
        }
    }
</script>