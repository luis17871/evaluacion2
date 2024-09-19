import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { IAsistente } from '../Interfaces/iasistentes';

@Injectable({
  providedIn: 'root'
})
export class AsistentesService {
  apiurl = 'http://localhost/Sexto/Sexto/Proyectos/03MVC/controllers/asistentes.controller.php?op=';
  constructor(private lector: HttpClient) {}
  todos(): Observable<IAsistente[]> {
    return this.lector.get<IAsistente[]>(this.apiurl + 'todos');
  }
  uno(asistente_id: number): Observable<IAsistente> {
    const formData = new FormData();
    formData.append('asistente_id', asistente_id.toString());
    return this.lector.post<IAsistente>(this.apiurl + 'uno', formData);
  }
  todosConferencia(asistente_id: number): Observable<IAsistente[]> {
    const formData = new FormData();
    formData.append('conferencia_id', asistente_id.toString());
    return this.lector.post<IAsistente[]>(this.apiurl + 'todosConferencia', formData);
  }
  todosConferenciano(asistente_id: number): Observable<IAsistente[]> {
    const formData = new FormData();
    formData.append('conferencia_id', asistente_id.toString());
    return this.lector.post<IAsistente[]>(this.apiurl + 'todosConferenciano', formData);
  }
  eliminar(asistente_id: number): Observable<number> {
    const formData = new FormData();
    formData.append('asistente_id', asistente_id.toString());
    return this.lector.post<number>(this.apiurl + 'eliminar', formData);
  }
  insertar(cliente: IAsistente): Observable<string> {
    const formData = new FormData();
    formData.append('nombre', cliente.nombre);
    formData.append('apellido', cliente.apellido);
    formData.append('email', cliente.email);
    formData.append('telefono', cliente.telefono);
    return this.lector.post<string>(this.apiurl + 'insertar', formData);
  }
  actualizar(cliente: IAsistente): Observable<string> {
    const formData = new FormData();
    formData.append('asistente_id', cliente.asistente_id.toString());
    formData.append('nombre', cliente.nombre);
    formData.append('apellido', cliente.apellido);
    formData.append('email', cliente.email);
    formData.append('telefono', cliente.telefono);
    return this.lector.post<string>(this.apiurl + 'actualizar', formData);
  }
}
