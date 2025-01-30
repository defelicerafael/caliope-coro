import { Directive } from '@angular/core';
import { ElementRef, Input, OnChanges, Renderer2 } from '@angular/core';

@Directive({
  selector: '[appCommaToList]',
  standalone: true
})
export class CommaToListDirective implements OnChanges{

  @Input('appCommaToList') textoConComas: string = '';

  constructor(private el: ElementRef, private renderer: Renderer2) {}

  ngOnChanges() {
    if (this.textoConComas) {
      // Limpiar el contenido actual del elemento
      this.renderer.setProperty(this.el.nativeElement, 'innerHTML', '');

      // Dividir el string por comas y eliminar espacios en blanco
      const items = this.textoConComas.split(',').map(item => item.trim());

      // Crear una lista <ul>
      const ul = this.renderer.createElement('ul');

      // Crear <li> para cada elemento del array y agregarlo al <ul>
      items.forEach(item => {
        const li = this.renderer.createElement('li');
        const text = this.renderer.createText(item);
        this.renderer.appendChild(li, text);
        this.renderer.appendChild(ul, li);
      });

      // Agregar <ul> al elemento nativo
      this.renderer.appendChild(this.el.nativeElement, ul);
    }
  }

}
