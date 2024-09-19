import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { ActivatedRoute, Router, RouterLink } from '@angular/router';
import { IAsistente } from 'src/app/Interfaces/iasistentes';
import { IConferencia } from 'src/app/Interfaces/iconferencia';
import { AsistentesService } from 'src/app/Services/asistentes.service';
import { ConfererenciaService } from 'src/app/Services/conferencias.service';
import { RegistroService } from 'src/app/Services/registroconferencia.service';
import { SharedModule } from 'src/app/theme/shared/shared.module';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-nuevaconferencia',
  standalone: true,
  imports: [ReactiveFormsModule, CommonModule, RouterLink, SharedModule],
  templateUrl: './nuevaconferencia.component.html',
})
export class NuevaconferenciaComponent {
  frm_Cliente = new FormGroup({
    //asistente_id: new FormControl(),
    nombre: new FormControl('', Validators.required),
    fecha: new FormControl('', Validators.required),
    ubicacion: new FormControl('', Validators.required),
    descripcion: new FormControl('', [Validators.required, ]),
  });
  listaasistentes: IAsistente[];
  listanoasistentes: IAsistente[];
  asistente_id = 0;
  titulo = 'Nuevo Cliente';
  constructor(
    private confereciaService: ConfererenciaService,
    private asistentesService: AsistentesService,
    private registroconferenciaService: RegistroService,
    private navegacion: Router,
    private ruta: ActivatedRoute,
  ) {}

  ngOnInit(): void {
    this.asistente_id = parseInt(this.ruta.snapshot.paramMap.get('id'));
    if (this.asistente_id > 0) {
      console.log(this.asistente_id);
      this.confereciaService.uno(this.asistente_id).subscribe((uncliente) => {
        console.log(uncliente);
        this.frm_Cliente.controls['nombre'].setValue(uncliente.nombre);
        this.frm_Cliente.controls['fecha'].setValue(uncliente.fecha);
        this.frm_Cliente.controls['ubicacion'].setValue(uncliente.ubicacion);
        this.frm_Cliente.controls['descripcion'].setValue(uncliente.descripcion);


        this.titulo = 'Editar Cliente';
      });
    }
    this.cargarAsistentes();
    this.cargarNoAsistentes();
  }
  cargarAsistentes(){
    this.asistentesService.todosConferencia(this.asistente_id).subscribe((data) => {
      this.listaasistentes = data;
    });
  }
  cargarNoAsistentes(){
    this.asistentesService.todosConferenciano(this.asistente_id).subscribe((data) => {
      this.listanoasistentes = data;
    });
  }
  agregarAsistente(idasistente:string){
    this.registroconferenciaService.insertar(parseInt(idasistente),this.asistente_id).subscribe((data) => {
      console.log(data);
      this.cargarAsistentes();
      this.cargarNoAsistentes();
    });
  }
  eliminarAsistente(idasistente:number){
    this.registroconferenciaService.eliminar(idasistente, this.asistente_id).subscribe((data) => {
      console.log(data);
      this.cargarAsistentes();
      this.cargarNoAsistentes();
    });
  }
  grabar() {
    let asistente: IConferencia = {
      conferencia_id: this.asistente_id,
      nombre: this.frm_Cliente.controls['nombre'].value,
      fecha: this.frm_Cliente.controls['fecha'].value,
      ubicacion: this.frm_Cliente.controls['ubicacion'].value,
      descripcion: this.frm_Cliente.controls['descripcion'].value,
    };

    Swal.fire({
      title: 'Clientes',
      text: 'Desea gurdar al Cliente ' + this.frm_Cliente.controls['nombre'].value,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#f00',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Grabar!'
    }).then((result) => {
      if (result.isConfirmed) {
        if (this.asistente_id > 0) {
          this.confereciaService.actualizar(asistente).subscribe((res: any) => {
            Swal.fire({
              title: 'conferencias',
              text: res.mensaje,
              icon: 'success'
            });
            this.navegacion.navigate(['/conferencias']);
          });
        } else {
          this.confereciaService.insertar(asistente).subscribe((res: any) => {
            Swal.fire({
              title: 'conferencias',
              text: res.mensaje,
              icon: 'success'
            });
            this.navegacion.navigate(['/conferencias']);
          });
        }
      }
    });
  }

}
