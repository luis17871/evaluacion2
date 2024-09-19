import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { IConferencia } from '../Interfaces/iconferencia';


@Injectable({
  providedIn: 'root'
})
export class ConfererenciaService {
  apiurl = 'http://localhost/Sexto/Sexto/Proyectos/03MVC/controllers/conferencias.controller.php?op=';
  constructor(private lector: HttpClient) {}
  todos(): Observable<IConferencia[]> {
    return this.lector.get<IConferencia[]>(this.apiurl + 'todos');
  }
  uno(conferencia_id: number): Observable<IConferencia> {
    const formData = new FormData();
    formData.append('conferencia_id', conferencia_id.toString());
    return this.lector.post<IConferencia>(this.apiurl + 'uno', formData);
  }
  eliminar(conferencia_id: number): Observable<number> {
    const formData = new FormData();
    formData.append('conferencia_id', conferencia_id.toString());
    return this.lector.post<number>(this.apiurl + 'eliminar', formData);
  }
  insertar(cliente: IConferencia): Observable<string> {
    const formData = new FormData();
    formData.append('nombre', cliente.nombre);
    formData.append('fecha', cliente.fecha);
    formData.append('ubicacion', cliente.ubicacion);
    formData.append('descripcion', cliente.descripcion);
    return this.lector.post<string>(this.apiurl + 'insertar', formData);
  }
  actualizar(cliente: IConferencia): Observable<string> {
    const formData = new FormData();
    formData.append('conferencia_id', cliente.conferencia_id.toString());
    formData.append('nombre', cliente.nombre);
    formData.append('fecha', cliente.fecha);
    formData.append('ubicacion', cliente.ubicacion);
    formData.append('descripcion', cliente.descripcion);
    return this.lector.post<string>(this.apiurl + 'actualizar', formData);
  }
}
