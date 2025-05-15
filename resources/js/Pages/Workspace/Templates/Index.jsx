import { useState } from 'react';

export default function Templates() {
    const [formData, setFormData] = useState({
        input1: '',
        input2: ''
    });

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({
            ...prev,
            [name]: value
        }));
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        console.log('Form data:', formData);
    };

    return (
        <div className="p-6 max-w-2xl mx-auto">
            <h1 className="text-2xl font-semibold mb-6">Templates</h1>
            
            <form onSubmit={handleSubmit} className="space-y-4">
                <div>
                    <label htmlFor="input1" className="block text-sm font-medium text-gray-700 mb-1">
                        First Input
                    </label>
                    <input
                        type="text"
                        id="input1"
                        name="input1"
                        value={formData.input1}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                        placeholder="Enter first value"
                    />
                </div>

                <div>
                    <label htmlFor="input2" className="block text-sm font-medium text-gray-700 mb-1">
                        Second Input
                    </label>
                    <input
                        type="text"
                        id="input2"
                        name="input2"
                        value={formData.input2}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                        placeholder="Enter second value"
                    />
                </div>

                <button
                    type="submit"
                    className="w-full bg-primary-600 text-white px-4 py-2 rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                >
                    Submit
                </button>
            </form>
        </div>
    );
}
