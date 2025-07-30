<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::paginate(10);
        return view('contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'company' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Contact::create($request->only(['name', 'phone', 'address', 'company']));

        return redirect()->route('contacts.index')
            ->with('success', 'Contact created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return view('contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contact = Contact::findOrFail($id);
        return view('contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'company' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $contact->update($request->only(['name', 'phone', 'address', 'company']));

        return redirect()->route('contacts.index')
            ->with('success', 'Contact updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('contacts.index')
            ->with('success', 'Contact deleted successfully.');
    }

    /**
     * Show the XML import form.
     *
     * @return \Illuminate\Http\Response
     */
    public function importForm()
    {
        return view('contacts.import');
    }

    /**
     * Import contacts from XML file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        // Basic file validation with more flexible approach
        $validator = Validator::make($request->all(), [
            'xml_file' => 'required|file|max:2048', // Remove mimes:xml as it's unreliable
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $xmlFile = $request->file('xml_file');
        
        // Check if file was uploaded
        if (!$xmlFile) {
            return redirect()->back()->with('error', 'No file was uploaded.');
        }
        
        // Check file extension manually for better reliability
        $allowedExtensions = ['xml'];
        $fileExtension = strtolower($xmlFile->getClientOriginalExtension());
        
        if (!in_array($fileExtension, $allowedExtensions)) {
            return redirect()->back()->with('error', 'Please upload a valid XML file.');
        }

        // Check if file is empty
        if ($xmlFile->getSize() == 0) {
            return redirect()->back()->with('error', 'The uploaded XML file is empty.');
        }

        $xmlContent = file_get_contents($xmlFile->getPathname());
        
        // Check if content was read successfully
        if ($xmlContent === false) {
            return redirect()->back()->with('error', 'Unable to read the uploaded file.');
        }

        try {
            $xml = simplexml_load_string($xmlContent);
            
            if ($xml === false) {
                return redirect()->back()->with('error', 'Invalid XML file format.');
            }

            $importedCount = 0;
            $errorCount = 0;
            $errors = [];

            foreach ($xml->contact as $contactXml) {
                $contactData = [
                    'name' => trim((string) $contactXml->name) ?: '',
                    'phone' => trim((string) $contactXml->phone) ?: null,
                    'address' => trim((string) $contactXml->address) ?: null,
                    'company' => trim((string) $contactXml->company) ?: null,
                ];

                $validator = Validator::make($contactData, [
                    'name' => 'required|string|max:255',
                    'phone' => 'nullable|string|max:20',
                    'address' => 'nullable|string',
                    'company' => 'nullable|string|max:255',
                ]);

                if ($validator->fails()) {
                    $errorCount++;
                    $errors[] = "Contact {$contactData['name']}: " . implode(', ', $validator->errors()->all());
                } else {
                    Contact::create($contactData);
                    $importedCount++;
                }
            }

            $message = "Import completed. {$importedCount} contacts imported successfully.";
            if ($errorCount > 0) {
                $message .= " {$errorCount} contacts failed to import.";
            }

            return redirect()->route('contacts.index')
                ->with('success', $message)
                ->with('import_errors', $errors);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error processing XML file: ' . $e->getMessage());
        }
    }
}
