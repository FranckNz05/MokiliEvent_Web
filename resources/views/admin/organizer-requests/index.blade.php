@extends('layouts.admin')

@section('title', 'Demandes d\'organisateur')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Demandes d'organisateur</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Demandes en attente
        </div>
        <div class="card-body">
            @if($requests->isEmpty())
                <div class="alert alert-info">
                    Aucune demande en attente.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Utilisateur</th>
                                <th>Entreprise</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requests as $request)
                                <tr>
                                    <td>{{ $request->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $request->user->name }}</td>
                                    <td>{{ $request->company_name }}</td>
                                    <td>{{ $request->company_email }}</td>
                                    <td>{{ $request->company_phone }}</td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailsModal{{ $request->id }}">
                                            <i class="fas fa-eye"></i> Détails
                                        </button>
                                        <form action="{{ route('admin.organizer-requests.approve', $request->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i> Approuver
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $request->id }}">
                                            <i class="fas fa-times"></i> Rejeter
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal Détails -->
                                <div class="modal fade" id="detailsModal{{ $request->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Détails de la demande</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h6>Informations de l'entreprise</h6>
                                                <p><strong>Nom :</strong> {{ $request->company_name }}</p>
                                                <p><strong>Adresse :</strong> {{ $request->company_address }}</p>
                                                <p><strong>Email :</strong> {{ $request->company_email }}</p>
                                                <p><strong>Téléphone :</strong> {{ $request->company_phone }}</p>
                                                
                                                <h6 class="mt-4">Description</h6>
                                                <p>{{ $request->description }}</p>

                                                @if(!empty($request->documents))
                                                    <h6 class="mt-4">Documents</h6>
                                                    <ul>
                                                        @foreach($request->documents as $document)
                                                            <li>
                                                                <a href="{{ Storage::url($document) }}" target="_blank">
                                                                    Document {{ $loop->iteration }}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Rejet -->
                                <div class="modal fade" id="rejectModal{{ $request->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Rejeter la demande</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.organizer-requests.reject', $request->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <p>Êtes-vous sûr de vouloir rejeter cette demande ?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <button type="submit" class="btn btn-danger">Rejeter</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
