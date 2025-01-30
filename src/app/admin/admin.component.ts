import { Component, inject, viewChild } from '@angular/core';

import { MatSidenavModule } from '@angular/material/sidenav';
import { MatListModule } from '@angular/material/list';
import { ToolbarComponent } from './home/toolbar/toolbar.component';
import { RouterModule } from '@angular/router';
import { ListadosComponent } from './home/listados/listados.component';
import { CommonModule } from '@angular/common';
import { DrawerService } from '../services/drawer.service';

import { MatIconModule } from '@angular/material/icon';
import { MatAccordion, MatExpansionModule } from '@angular/material/expansion';
import { MenuService } from '../services/menu.service';

@Component({
    selector: 'app-admin',
    standalone:true,
    templateUrl: './admin.component.html',
    styleUrls: ['./admin.component.css'],
    imports: [
        MatSidenavModule,
        MatListModule,
        ToolbarComponent,
        RouterModule,
        ListadosComponent,
        CommonModule,
        MatIconModule,
        MatExpansionModule
    ]
})
export class AdminComponent {
  opened = false;
  accordion = viewChild.required(MatAccordion);
  private menuService = inject(MenuService);
  public folders = this.menuService.folders;

  constructor(
    private sidenavService: DrawerService,
    ) {
    this.sidenavService.isOpened$.subscribe((isOpened) => {
      this.opened = isOpened;
    });
  }

  
  
}
