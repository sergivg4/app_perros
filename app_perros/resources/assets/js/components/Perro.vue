<template>

    <div class="container" style="margin: auto;">
        
        <!-- Sección de información del perro seleccionado -->
        <div class="row featurette" v-if="infoMode">
          <div class="col-md-7">
            <h2 class="featurette-heading">{{addData.raza}}</h2>
            <br>
            <p class="lead"><b>Tamaño:</b><br>{{addData.size}}</p>
            <p class="lead"><b>Descripción:</b><br>{{addData.descripcion}}</p>
            <button class="btn btn-danger" v-on:click="cancelInfoPerro()">Volver</button><br>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto" :src="'storage/'+addData.imagen" style="width: 300px;">
          </div>
        </div>


        <!-- Sección principal: Tabla y formulario -->
        <div v-else>

            <h2>Tabla de perros</h2>
        
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Raza</th>
                        <th scope="col">Tamaño</th>
                        <th scope="col">Descripcion</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="models in model.data">
                    <th scope="row">{{models.id}}</th>
                        <td>{{models.raza}}</td>
                        <td>{{models.size}}</td>
                        <td>{{models.descripcion.substr(0, 50)}}...</td>
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


            <!-- Formulario de CREAR perro -->
            <form v-on:submit.prevent="addPerro()" v-if="!editMode" enctype="multipart/form-data">
                
                <h2>Añadir perro</h2>

                <div class="form-group">
                    <input type="text" class="form-control" placeholder="raza" name="raza" v-model="addData.raza"/>
                </div>

                <div class="form-group">
                    <select class="form-control" v-model="addData.size">
                        <option disabled value="">Please select one</option>
                        <option>Pequeño</option>
                        <option>Mediano</option>
                        <option>Grande</option>
                    </select>
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

                <br>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>


            <!-- Formulario de EDITAR perro -->
            <form v-on:submit.prevent="editPerro(addData)" v-else>
                
                <h2>Editar perro</h2>

                <div class="form-group">
                    <input type="text" class="form-control" placeholder="raza" name="raza" v-model="addData.raza"/>
                </div>

                <div class="form-group">
                    <select class="form-control" v-model="addData.size">
                        <option>Pequeño</option>
                        <option>Mediano</option>
                        <option>Grande</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="descripcion" name="descripcion" v-model="addData.descripcion"/>
                </div>

                <input type="hidden" name="imagen" v-model="addData.imagen">

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
                addData: {'id':'', 'raza':'', 'size':'', 'descripcion':'', 'imagen':''},
                editMode: false,
                infoMode: false
            }
        },
        // Recibe la información de la BBDD antes de cargar el DOM
        created: function(){
            this.fetchDataPerro()
        },
        methods: {
            // Recibe la información de la BBDD
            fetchDataPerro(){
                var vm = this
                axios.get('api/perro')
                    .then(function (response) {
                        Vue.set(vm.$data, 'model', response.data.model);
                        //console.log(response.data.model.data);
                    })
            },
            // Pasa la información de un perro y su imagen, luego actualiza la tabla principal.
            addPerro(){
                var vm = this
                let formData = new FormData();
                formData.append('raza',this.addData.raza);
                formData.append('size',this.addData.size);
                formData.append('descripcion',this.addData.descripcion);
                formData.append('imagen',this.addData.imagen);

                axios.post('api/perro/add', formData)
                    .then(function (response) {
                        vm.addData={'id':'', 'raza':'', 'size':'', 'descripcion':'', 'imagen':''}
                        //console.log('success');
                        console.log(response.data);
                    })
                this.fetchDataPerro();this.fetchDataPerro();
            },
            showEditForm(data){
                this.editMode = true;
                this.addData.id = data.id;
                this.addData.raza = data.raza;
                this.addData.size = data.size;
                this.addData.descripcion = data.descripcion;
                this.addData.imagen = data.imagen;
                //console.log(this.editMode);
            },
            cancelEditForm(){
                this.editMode = false;
                this.addData.id = '';
                this.addData.raza = '';
                this.addData.size = '';
                this.addData.descripcion = '';
                //console.log(this.editMode);
            },
            showInfoPerro(data){
                this.infoMode = true;
                this.addData.id = data.id;
                this.addData.raza = data.raza;
                this.addData.size = data.size;
                this.addData.descripcion = data.descripcion;
                this.addData.imagen = data.imagen;
                //console.log(this.editMode);
            },
            cancelInfoPerro(){
                this.infoMode = false;
                this.addData.id = '';
                this.addData.raza = '';
                this.addData.size = '';
                this.addData.descripcion = '';
                //console.log(this.editMode);
            },
            // Pasa la información del perro editado y actualiza la tabla principal.
            editPerro(data){
                //console.log(data)
                axios.post('api/perro/edit/', data)
                    // .then(function (response) {
                    //     console.log(response)
                    // });
                this.editMode = false;
                this.fetchDataPerro();
            },
            // Pasa la información del perro que se va a eliminar y actualiza la tabla principal.
            removePerro(data){
                //console.log(data.id)
                axios.post('api/perro/remove/', data)
                
                this.fetchDataPerro();
            },
            // Recibe la imagen subida por el usuario
            getImage(e){
                let file = e.target.files[0];
                    //console.log(file);
                this.addData.imagen = file;
                this.loadImage(file);
            },
            // Guarda la imagen en this.thumbnail como un archivo
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