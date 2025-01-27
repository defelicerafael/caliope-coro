import { Injectable } from '@angular/core';
export interface Section {
  name: string;
}
@Injectable({
  providedIn: 'root'
})
export class MenuService {

  constructor() { }
  folders: Section[] = [
      {
      name: 'bio'
      },
      {
        name: 'blog'
      },
      
      {
      name: 'books'
      },
      
      {
      name: 'media'
      },
      
      {
      name: 'praise'
      },
      
      {
      name: 'teaching'
      },
      {
      name: 'topics'
      },
      {
      name: 'suscriptores'
      },
      {
      name: 'events'
      }
  ];
}
