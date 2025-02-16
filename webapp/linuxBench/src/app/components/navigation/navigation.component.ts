import { Component } from '@angular/core';
import {Router, RouterLink} from '@angular/router';
import {AuthService} from '../../services/auth.service';
import {CommonModule} from '@angular/common';

@Component({
  selector: 'app-navigation',
  imports: [RouterLink, CommonModule],
  templateUrl: './navigation.component.html',
  styleUrl: './navigation.component.css'
})
export class NavigationComponent {
  public idToken:string = "";
  public username:string = "";

  constructor(private auth:AuthService, private router:Router) {
    let token = localStorage.getItem('token');
    let name = localStorage.getItem('name');
    if (token != null) {
      this.idToken = token;
    }
    if (name != null) {
      this.username = name;
    }
  }

  public deleteStorage(){
    this.auth.deleteStorage();
    this.router.navigate(['about']).then(()=>{
      window.location.reload();
    })
  }
}
