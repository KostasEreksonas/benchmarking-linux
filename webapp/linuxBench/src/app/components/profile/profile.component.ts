import { Component } from '@angular/core';
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import {LoadingComponent} from '../loading/loading.component';
import {CommonModule} from '@angular/common';
import {Bench} from '../../models/bench';
import {BenchResultsService} from '../../services/bench-results.service';
import {ActivatedRoute, RouterLink} from '@angular/router';
import {AuthService} from '../../services/auth.service';

@Component({
  selector: 'app-profile',
  imports: [
    FormsModule,
    ReactiveFormsModule,
    LoadingComponent,
    CommonModule,
    RouterLink,
  ],
  templateUrl: './profile.component.html',
  styleUrl: './profile.component.css'
})
export class ProfileComponent {
  public email:string|null = "";
  public username:string = "";
  public date:string|null = "";
  public benches:Bench[] = [];
  public isLoading:boolean = false;
  public isError:boolean = false;
  public edit:boolean = false;
  public token:string|null = '';
  public status:number = 0;
  public message:string = '';

  public constructor(private route:ActivatedRoute, private auth:AuthService, private benchService:BenchResultsService) {
    this.username = this.route.snapshot.params["username"];
    this.token = localStorage.getItem('token');
    if (this.username === localStorage.getItem('name')) {
      this.edit = true;
    }

    this.auth.loadData(this.username).subscribe({
      next:(data)=>{
        this.email = data.email;
        this.date = data.created_at;
      },
      error:(error)=>{
        this.status = error.error.status;
        this.message = error.error.message;
      }
    })

    let benchmarks = ["ffmpeg"];
    for (let b in benchmarks) {
      this.benchService.userResults(benchmarks[b], this.username).subscribe({
        next:(data)=>{
          for (let k in data) {
            this.benches.push(data[k]);
          }
        }
      })
    }
  }

  public deleteResult(benchmark:string, id:string|null){
    if (id != null) {
      this.benchService.deleteResult(benchmark, id).subscribe( ()=>{
        window.location.reload();
      });
    }
  }
}
