@extends('layouts.app')

@section('content')
<div id="app">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa fa-users me-2"></i>Clientes — Vue/Quasar</h2>
        <button class="btn btn-primary" @click="abrirModalCrear">
            <i class="fa fa-plus me-1"></i> Nuevo Cliente
        </button>
    </div>

    {{-- Mensaje de éxito/error --}}
    <div v-if="mensaje" :class="'alert alert-' + tipoMensaje + ' alert-dismissible'" role="alert">
        <i class="fa fa-check-circle me-2"></i>[[ mensaje ]]
        <button type="button" class="btn-close" @click="mensaje = ''"></button>
    </div>

    {{-- Tabla de clientes --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>CIF</th>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>País</th>
                        <th>Cuota</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="cargando">
                        <td colspan="7" class="text-center py-4">
                            <div class="spinner-border text-primary"></div>
                            Cargando...
                        </td>
                    </tr>
                    <tr v-else-if="clientes.length === 0">
                        <td colspan="7" class="text-center text-muted py-4">
                            No hay clientes registrados.
                        </td>
                    </tr>
                    <tr v-else v-for="cliente in clientes" :key="cliente.id">
                        <td>[[ cliente.cif ]]</td>
                        <td>[[ cliente.nombre ]]</td>
                        <td>[[ cliente.telefono ]]</td>
                        <td>[[ cliente.correo ]]</td>
                        <td>[[ cliente.pais ?? '-' ]]</td>
                        <td>[[ cliente.importe_cuota ]] [[ cliente.moneda ]]</td>
                        <td>
                            <button class="btn btn-sm btn-warning me-1"
                                    @click="abrirModalEditar(cliente)">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger"
                                    @click="eliminarCliente(cliente)">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Crear/Editar --}}
    <div class="modal fade" id="modalCliente" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">
                        [[ modoEdicion ? 'Editar Cliente' : 'Nuevo Cliente' ]]
                    </h5>
                    <button type="button" class="btn-close btn-close-white"
                            data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    {{-- Errores de validación --}}
                    <div v-if="Object.keys(errores).length > 0" class="alert alert-danger">
                        <ul class="mb-0">
                            <li v-for="(error, campo) in errores" :key="campo">
                                [[ error[0] ]]
                            </li>
                        </ul>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">CIF *</label>
                            <input type="text" v-model="formulario.cif"
                                   :class="'form-control' + (errores.cif ? ' is-invalid' : '')"
                                   placeholder="B12345678">
                            <div v-if="errores.cif" class="invalid-feedback">
                                [[ errores.cif[0] ]]
                            </div>
                        </div>
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Nombre *</label>
                            <input type="text" v-model="formulario.nombre"
                                   :class="'form-control' + (errores.nombre ? ' is-invalid' : '')"
                                   placeholder="Empresa S.L.">
                            <div v-if="errores.nombre" class="invalid-feedback">
                                [[ errores.nombre[0] ]]
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Teléfono *</label>
                            <input type="text" v-model="formulario.telefono"
                                   :class="'form-control' + (errores.telefono ? ' is-invalid' : '')"
                                   placeholder="600000000">
                            <div v-if="errores.telefono" class="invalid-feedback">
                                [[ errores.telefono[0] ]]
                            </div>
                        </div>
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Correo *</label>
                            <input type="email" v-model="formulario.correo"
                                   :class="'form-control' + (errores.correo ? ' is-invalid' : '')"
                                   placeholder="cliente@empresa.com">
                            <div v-if="errores.correo" class="invalid-feedback">
                                [[ errores.correo[0] ]]
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Cuenta Corriente</label>
                            <input type="text" v-model="formulario.cuenta_corriente"
                                   class="form-control"
                                   placeholder="ES00 0000 0000 0000">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">País</label>
                            <input type="text" v-model="formulario.pais"
                                   class="form-control" placeholder="España">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Moneda</label>
                            <input type="text" v-model="formulario.moneda"
                                   class="form-control" placeholder="EUR">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Importe Cuota *</label>
                            <div class="input-group">
                                <input type="number" v-model="formulario.importe_cuota"
                                       :class="'form-control' + (errores.importe_cuota ? ' is-invalid' : '')"
                                       step="0.01" min="0">
                                <span class="input-group-text">€</span>
                            </div>
                            <div v-if="errores.importe_cuota" class="invalid-feedback d-block">
                                [[ errores.importe_cuota[0] ]]
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary"
                            @click="guardarCliente" :disabled="guardando">
                        <span v-if="guardando">
                            <span class="spinner-border spinner-border-sm me-1"></span>
                            Guardando...
                        </span>
                        <span v-else>
                            <i class="fa fa-save me-1"></i>
                            [[ modoEdicion ? 'Guardar Cambios' : 'Crear Cliente' ]]
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
{{-- Vue 3 CDN --}}
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>

{{-- Axios CDN --}}
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
const { createApp } = Vue;

createApp({
    // Usamos delimitadores diferentes para no chocar con Blade
    delimiters: ['[[', ']]'],

    data() {
        return {
            clientes: [],
            cargando: true,
            mensaje: '',
            tipoMensaje: 'success',
            modoEdicion: false,
            clienteEditandoId: null,
            guardando: false,
            errores: {},
            formulario: {
                cif: '',
                nombre: '',
                telefono: '',
                correo: '',
                cuenta_corriente: '',
                pais: '',
                moneda: '',
                importe_cuota: 0,
            }
        }
    },

    mounted() {
        // Configurar Axios con el token CSRF de Laravel
        axios.defaults.headers.common['X-CSRF-TOKEN'] =
            document.querySelector('meta[name="csrf-token"]')?.content;

        this.cargarClientes();
    },

    methods: {
        // Carga todos los clientes desde la API
        async cargarClientes() {
            this.cargando = true;
            try {
                const response = await axios.get('/admin/api/clientes');
                this.clientes = response.data;
            } catch (error) {
                this.mostrarMensaje('Error al cargar los clientes.', 'danger');
            } finally {
                this.cargando = false;
            }
        },

        // Abre el modal para crear un cliente nuevo
        abrirModalCrear() {
            this.modoEdicion = false;
            this.clienteEditandoId = null;
            this.errores = {};
            this.formulario = {
                cif: '', nombre: '', telefono: '', correo: '',
                cuenta_corriente: '', pais: '', moneda: '', importe_cuota: 0
            };
            new bootstrap.Modal(document.getElementById('modalCliente')).show();
        },

        // Abre el modal para editar un cliente existente
        abrirModalEditar(cliente) {
            this.modoEdicion = true;
            this.clienteEditandoId = cliente.id;
            this.errores = {};
            this.formulario = { ...cliente };
            new bootstrap.Modal(document.getElementById('modalCliente')).show();
        },

        // Valida el formulario antes de enviar
        validarFormulario() {
            this.errores = {};

            if (!this.formulario.cif) {
                this.errores.cif = ['El CIF es obligatorio.'];
            }
            if (!this.formulario.nombre) {
                this.errores.nombre = ['El nombre es obligatorio.'];
            }
            if (!this.formulario.telefono) {
                this.errores.telefono = ['El teléfono es obligatorio.'];
            }
            if (!this.formulario.correo) {
                this.errores.correo = ['El correo es obligatorio.'];
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.formulario.correo)) {
                this.errores.correo = ['El formato del correo no es válido.'];
            }
            if (this.formulario.importe_cuota < 0) {
                this.errores.importe_cuota = ['El importe no puede ser negativo.'];
            }

            return Object.keys(this.errores).length === 0;
        },

        // Guarda el cliente (crear o editar)
        async guardarCliente() {
            // Validación en cliente antes de enviar
            if (!this.validarFormulario()) {
                return;
            }

            this.guardando = true;

            try {
                if (this.modoEdicion) {
                    await axios.put(
                        `/admin/api/clientes/${this.clienteEditandoId}`,
                        this.formulario
                    );
                    this.mostrarMensaje('Cliente actualizado correctamente.', 'success');
                } else {
                    await axios.post('/admin/api/clientes', this.formulario);
                    this.mostrarMensaje('Cliente creado correctamente.', 'success');
                }

                bootstrap.Modal.getInstance(
                    document.getElementById('modalCliente')
                ).hide();

                await this.cargarClientes();

            } catch (error) {
                if (error.response?.status === 422) {
                    // Errores de validación del servidor
                    this.errores = error.response.data.errors;
                } else {
                    this.mostrarMensaje('Error al guardar el cliente.', 'danger');
                }
            } finally {
                this.guardando = false;
            }
        },

        // Elimina un cliente con confirmación
        async eliminarCliente(cliente) {
            if (!confirm(`¿Seguro que quieres eliminar a ${cliente.nombre}?`)) {
                return;
            }

            try {
                await axios.delete(`/admin/api/clientes/${cliente.id}`);
                this.mostrarMensaje('Cliente eliminado correctamente.', 'success');
                await this.cargarClientes();
            } catch (error) {
                this.mostrarMensaje('Error al eliminar el cliente.', 'danger');
            }
        },

        // Muestra un mensaje de éxito o error
        mostrarMensaje(texto, tipo) {
            this.mensaje = texto;
            this.tipoMensaje = tipo;
            setTimeout(() => { this.mensaje = ''; }, 4000);
        }
    }

}).mount('#app');
</script>
@endpush