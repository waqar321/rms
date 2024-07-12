    <div wire:ignore.self >
        <a wire:poll="UpdateCount" wire:click="UpdateNotificationToSeen" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-envelope-o" style="font-size: 20px; !important; margin-top: 4px;"></i>
            <span class="badge bg-green"> {{ $count }} </span>
        </a>

        <ul wire:poll="UpdateCount" wire:ignore.self class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
                
            @php  
                $Notificationcount = 0; 
                $No_Record = 0; 
            @endphp 

            @forelse($notificationMessages as $key => $Notification)
                @if(CheckAlignment($Notification, 'notification'))
                    @if($Notification->NotificationStatuses)

                        @php
                            $userIds = $Notification->NotificationStatuses->pluck('user_id')->toArray();
                            $authUserId = auth()->user()->id;
                        @endphp

                        @if(in_array($authUserId, $userIds))
                            @php
                                $userNotificationStatus = $Notification->NotificationStatuses->where('user_id', $authUserId)->first();
                            @endphp
        
                            @if($userNotificationStatus && $userNotificationStatus->read == 0)
                                    
                                    <li wire:click="UpdateNotificationToRead({{ $Notification }})" wire:key="{{ $Notification->id }}" class="nav-item">
                                        <a class="dropdown-item">
                                            <span class="image">
                                                <img src="{{ asset('images/img.jpg') }}" alt="Profile Image" /></span>
                                            <span>
                                                <span>  {{$Notification->title }}</span>
                                                <span class="time">{{ getTimeDifference($Notification->created_at) }} </span>
                                            </span>
                                            <span class="message">
                                                {!! $Notification->messagebody !!}
                                            </span>
                                        </a> 
                                    </li>       
                                
                                    @if($key === 3)
                                        <li class="nav-item" wire:key="{{ $Notification->id }}">
                                            <div class="text-center">
                                            <a href="{{ route('notification.index') }}" class="dropdown-item">
                                                <strong>See All Alerts</strong>
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                            </div>
                                        </li> 
                                    @endif 
                
                                    @php $Notificationcount++ @endphp 

                            @endif 
                        @endif 
                    @endif 
                @endif 
            @empty 
                @php $No_Record++ @endphp 
                <li class="nav-item">
                    <div class="text-center">
                    <a class="dropdown-item">
                        <strong>No Notifications !!!</strong>
                        <i class="fa fa-angle-right"></i>
                    </a>
                    </div>
                </li>
            @endforelse      
            
            @if($No_Record == 0 && $Notificationcount == 0)
                <li class="nav-item">
                    <div class="text-center">
                    <a class="dropdown-item">
                        <strong>Not Any New Notification!!!</strong>
                        <i class="fa fa-angle-right"></i>
                    </a>
                    </div>
                </li>
            @endif 

            <!-- <li class="nav-item">
                <div class="text-center">
                <a class="dropdown-item">
                    <strong>testing awdawd awdaw  <br> No_Record: {{ $No_Record }}  <br> Notificationcount :  {{ $Notificationcount }} <br></strong>
                    <i class="fa fa-angle-right"></i>
                </a>
                </div>
            </li> -->
        </ul>
</div> 
