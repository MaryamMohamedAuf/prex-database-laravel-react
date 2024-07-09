import { useEffect } from 'react';
import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Head, useForm } from '@inertiajs/react';

export default function Create() {
    const { data, setData, post, processing, errors, reset } = useForm({
        number: '',
        name: '',
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('cohorts.store'));
    };

    return (
        <GuestLayout>
            <Head title="Create Cohort" />

            <form onSubmit={submit}>
                <div>
                    <InputLabel htmlFor="name" value="Name" />
                    <TextInput
                        id="name"
                        name="name"
                        value={data.name}
                        className="mt-1 block w-full"
                        autoComplete="name"
                        isFocused={true}
                        onChange={(e) => setData('name', e.target.value)}
                        required
                    />
                    <InputError message={errors.name} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="number" value="Number" />
                    <TextInput
                        id="number"
                        type="number"
                        name="number"
                        value={data.number}
                        className="mt-1 block w-full"
                        autoComplete="number"
                        onChange={(e) => setData('number', e.target.value)}
                        required
                    />
                    <InputError message={errors.number} className="mt-2" />
                </div>

                <div className="flex items-center justify-end mt-4">
                    <PrimaryButton className="ms-4" disabled={processing}>
                        Create
                    </PrimaryButton>
                </div>
            </form>
        </GuestLayout>
    );
}
