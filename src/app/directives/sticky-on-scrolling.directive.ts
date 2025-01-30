import { Directive, ElementRef, HostListener, Input, Renderer2 } from '@angular/core';

@Directive({
  selector: '[appStickyOnScrolling]',
  standalone: true
})
export class StickyOnScrollingDirective {

  @Input() stickyOffset = 0; // Altura en píxeles a partir de la cual será sticky
  private isSticky = false; // Controla si el elemento ya está "sticky"

  constructor(private el: ElementRef, private renderer: Renderer2) {}

  @HostListener('window:scroll', [])
  onWindowScroll() {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    // Si el scroll ha pasado la altura especificada y no está sticky
    if (scrollTop > this.stickyOffset && !this.isSticky) {
      this.renderer.addClass(this.el.nativeElement, 'sticky');
      this.isSticky = true;
    } 
    // Si el scroll está por debajo de la altura y el elemento está sticky
    else if (scrollTop <= this.stickyOffset && this.isSticky) {
      this.renderer.removeClass(this.el.nativeElement, 'sticky');
      this.isSticky = false;
    }
  }

}
