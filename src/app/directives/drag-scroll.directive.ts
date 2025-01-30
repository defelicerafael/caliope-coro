import { Directive, HostListener, ElementRef, Renderer2 } from '@angular/core';

@Directive({
  selector: '[appDragScroll]',
  standalone: true
})
export class DragScrollDirective {

  private isDown = false;
  private startX: number = 0;
  private scrollLeft: number = 0;

  constructor(private el: ElementRef, private renderer: Renderer2) {
    this.renderer.setStyle(this.el.nativeElement, 'cursor', 'grab'); // Cambia el cursor
  }

  @HostListener('mousedown', ['$event']) onMouseDown(event: MouseEvent) {
    this.isDown = true;
    this.startX = event.pageX - this.el.nativeElement.offsetLeft;
    this.scrollLeft = this.el.nativeElement.scrollLeft;
    this.renderer.setStyle(this.el.nativeElement, 'cursor', 'grabbing');
    this.renderer.addClass(this.el.nativeElement, 'no-select');
  }

  @HostListener('mouseleave') onMouseLeave() {
    this.isDown = false;
    this.renderer.setStyle(this.el.nativeElement, 'cursor', 'grab');
    this.renderer.addClass(this.el.nativeElement, 'no-select');
  }

  @HostListener('mouseup') onMouseUp() {
    this.isDown = false;
    this.renderer.setStyle(this.el.nativeElement, 'cursor', 'grab');
    this.renderer.addClass(this.el.nativeElement, 'no-select');
  }

  @HostListener('mousemove', ['$event']) onMouseMove(event: MouseEvent) {
    if (!this.isDown) return;
    event.preventDefault();
    const x = event.pageX - this.el.nativeElement.offsetLeft;
    const walk = (x - this.startX) * 2; // Multiplica por 2 para aumentar la velocidad del desplazamiento
    this.el.nativeElement.scrollLeft = this.scrollLeft - walk;
  }

}
